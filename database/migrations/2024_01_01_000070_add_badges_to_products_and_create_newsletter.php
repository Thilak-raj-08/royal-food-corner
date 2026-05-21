<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_vegetarian')->default(false)->after('description');
            $table->string('spice_level', 10)->default('none')->after('is_vegetarian'); // none|mild|medium|hot
            $table->boolean('is_featured')->default(false)->after('spice_level');
            $table->unsignedInteger('prep_minutes')->default(20)->after('is_featured');
        });

        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('subscribed_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_vegetarian', 'spice_level', 'is_featured', 'prep_minutes']);
        });
        Schema::dropIfExists('newsletter_subscribers');
    }
};
