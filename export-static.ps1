# Royal Food Corner - Static Export Script
# Downloads all rendered Laravel pages and assets into ./static/
# for deployment to Vercel as a frontend-only portfolio demo.

$ErrorActionPreference = 'Stop'
$base    = 'http://localhost:8000'
$out     = Join-Path $PSScriptRoot 'static'
$session = New-Object Microsoft.PowerShell.Commands.WebRequestSession

# Helper: fetch URL and return HTML body even on 4xx/5xx
function Get-PageHtml($url) {
    try {
        $resp = Invoke-WebRequest -Uri $url -UseBasicParsing -WebSession $session -TimeoutSec 30 -MaximumRedirection 5
        return $resp.Content
    } catch [System.Net.WebException] {
        if ($_.Exception.Response) {
            $stream = $_.Exception.Response.GetResponseStream()
            $reader = New-Object System.IO.StreamReader($stream)
            $body = $reader.ReadToEnd()
            $reader.Close()
            return $body
        }
        throw
    }
}

$routes = [ordered]@{
    'index.html'                  = '/'
    'menu.html'                   = '/menu'
    'menu/main-courses.html'      = '/menu?category=Main+Courses'
    'menu/desserts.html'          = '/menu?category=Desserts'
    'menu/beverages.html'         = '/menu?category=Beverages'
    'gallery.html'                = '/gallery'
    'reservations.html'           = '/reservations'
    'cart.html'                   = '/cart'
    'login.html'                  = '/login'
    'register.html'               = '/register'
    'admin/login.html'            = '/admin/login'
    '404.html'                    = '/this-does-not-exist'
}

$productIds = 1, 5, 12, 16, 22
foreach ($id in $productIds) { $routes["menu/product-$id.html"] = "/menu/$id" }

if (Test-Path $out) { Remove-Item $out -Recurse -Force }
New-Item -ItemType Directory -Path $out -Force | Out-Null
Write-Host "Output folder: $out" -ForegroundColor Cyan

Write-Host "Copying assets..." -ForegroundColor Cyan
Copy-Item "$PSScriptRoot\public\build"  -Destination "$out\build"  -Recurse
Copy-Item "$PSScriptRoot\public\images" -Destination "$out\images" -Recurse

Write-Host ""
Write-Host "Fetching pages..." -ForegroundColor Cyan

$ribbon = '<div style="position:fixed;bottom:80px;right:6px;z-index:9999;background:linear-gradient(135deg,#C8102E,#85091E);color:#fff;font-family:Inter,sans-serif;padding:10px 14px;border-radius:12px;font-size:11px;font-weight:600;box-shadow:0 8px 24px -8px rgba(75,52,38,.4);max-width:240px;line-height:1.4"><div style="font-family:Georgia,serif;font-size:13px;font-weight:800;margin-bottom:2px">Live Demo Mode</div>This is a frontend showcase. Forms and cart are disabled. Source on <a href="https://github.com/Thilak-raj-08/royal-food-corner" target="_blank" style="color:#FFD700;text-decoration:underline">GitHub</a>.</div>'

foreach ($pair in $routes.GetEnumerator()) {
    $filename = $pair.Key
    $url      = "$base$($pair.Value)"
    $dest     = Join-Path $out $filename
    $destDir  = Split-Path $dest -Parent
    if (-not (Test-Path $destDir)) { New-Item -ItemType Directory -Path $destDir -Force | Out-Null }

    try {
        $html = Get-PageHtml $url

        # Normalize: absolute localhost -> root-relative
        $html = $html -replace 'http://localhost:8000', ''
        # Disable form submissions (no backend)
        $html = $html -replace 'action="/[^"]*"', 'action="#" data-static="true"'
        # Strip CSRF tokens
        $html = $html -replace '<input type="hidden" name="_token" value="[^"]*">', ''

        if ($filename -ne '404.html') {
            $html = $html -replace '</body>', "$ribbon`n</body>"
        }

        Set-Content -Path $dest -Value $html -Encoding UTF8
        $sizeKb = [math]::Round($html.Length / 1024, 1)
        Write-Host ("  OK  {0}  ({1} KB)" -f $filename, $sizeKb) -ForegroundColor Green
    }
    catch {
        Write-Host ("  ERR {0}  {1}" -f $filename, $_.Exception.Message) -ForegroundColor Red
    }
}

Write-Host ""
Write-Host "Writing vercel.json..." -ForegroundColor Cyan
$vercelConfig = @'
{
  "cleanUrls": true,
  "trailingSlash": false,
  "rewrites": [
    { "source": "/menu",         "destination": "/menu.html" },
    { "source": "/gallery",      "destination": "/gallery.html" },
    { "source": "/reservations", "destination": "/reservations.html" },
    { "source": "/cart",         "destination": "/cart.html" },
    { "source": "/login",        "destination": "/login.html" },
    { "source": "/register",     "destination": "/register.html" }
  ],
  "headers": [
    {
      "source": "/build/(.*)",
      "headers": [
        { "key": "Cache-Control", "value": "public, max-age=31536000, immutable" }
      ]
    }
  ]
}
'@
Set-Content -Path (Join-Path $out 'vercel.json') -Value $vercelConfig -Encoding UTF8

Write-Host ""
Write-Host "===================================="
Write-Host "Static export complete!" -ForegroundColor Green
Write-Host "   Folder: $out"
Write-Host ("   Pages : {0}" -f $routes.Count)
Write-Host "   Next  : Push to GitHub or run 'vercel' inside static/"
