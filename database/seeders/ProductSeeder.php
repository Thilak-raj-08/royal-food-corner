<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['Chicken Biriyani', 940.00, 'Main Courses', "RFC Chicken Biryani: Tender chicken, aromatic spices, perfect cooking, a delightful culinary experience in every bite.", 'mc1.jpg'],
            ['Fish Biriyani', 915.00, 'Main Courses', "RFC Fish Biryani: Flaky fish, fragrant spices, delectable blend, an unforgettable culinary journey in every mouthful.", 'mc2.jpg'],
            ['Mutton Biriyani', 1350.00, 'Main Courses', "RFC Mutton Biryani: Succulent meat, aromatic spices, sublime fusion, a gastronomic adventure in every savory bite.", 'mc3.jpg'],
            ['Vegetable Biriyani', 580.00, 'Main Courses', "RFC Vegetable Biryani: Fresh veggies, fragrant spices, flavorful medley, a delightful vegetarian culinary experience.", 'mc4.jpg'],
            ['Egg Biriyani', 660.00, 'Main Courses', "RFC Egg Biryani: Boiled eggs, aromatic spices, a savory symphony, a delightful egg-based culinary experience.", 'mc5.jpg'],
            ['Beef Biriyani', 790.00, 'Main Courses', "RFC Beef Biryani: Tender beef, aromatic spices, a savory masterpiece, a culinary delight in every mouthful.", 'mc6.png'],
            ['Veg Kottu', 570.00, 'Main Courses', "RFC Veg Kottu: Chopped vegetables, flavorful seasonings, a delightful vegetarian stir-fry, a satisfying culinary experience.", 'mc7.jpg'],
            ['Egg Kottu', 650.00, 'Main Courses', "RFC Egg Kottu: Scrambled eggs, aromatic spices, a delectable egg-based stir-fry, a satisfying culinary journey.", 'mc8.jpg'],
            ['Mixed Kottu', 800.00, 'Main Courses', "RFC Mixed Kottu: A fusion of ingredients, spices, and flavors, a delightful and diverse culinary creation.", 'mc9.jpg'],
            ['Chicken Kottu', 750.00, 'Main Courses', "RFC Chicken Kottu: Shredded chicken, aromatic spices, a delightful chicken-based stir-fry, a satisfying and flavorful culinary experience.", 'mc10.jpg'],
            ['Mutton Kottu', 1100.00, 'Main Courses', "RFC Mutton Kottu: Tender mutton, fragrant spices, a savory mutton-based stir-fry, a delectable and satisfying culinary journey.", 'mc11.jpg'],
            ['Beef Kottu', 750.00, 'Main Courses', "RFC Beef Kottu: Tender beef, aromatic spices, a flavorful beef-based stir-fry, a satisfying and savory culinary delight.", 'mc12.jpg'],
            ['Noodles', 600.00, 'Main Courses', "RFC Noodles: Stir-fried strands, flavorful seasonings, a delightful and satisfying noodle dish for all to enjoy.", 'mc13.jpg'],
            ['Chapathi', 450.00, 'Main Courses', "RFC Chapathi: Soft, unleavened flatbreads, a versatile and classic staple in Indian cuisine.", 'mc14.jpg'],
            ['Fried Rice', 750.00, 'Main Courses', "RFC Fried Rice: A flavorful medley of rice, vegetables, and seasonings, a satisfying and savory dish.", 'mc15.jpg'],
            ['Ice Cream', 400.00, 'Desserts', "RFC Ice Cream: Creamy, sweet, and delightful frozen dessert available in a variety of delicious flavors.", 'd1.jpg'],
            ['Cream Caramel', 480.00, 'Desserts', "RFC Cream Caramel: A luscious, sweet custard dessert with a rich caramel sauce, a delectable treat to satisfy your sweet tooth.", 'd2.jpg'],
            ['Cream of Tomato', 385.00, 'Desserts', "RFC Cream of Tomato: A velvety, tomato-based soup, enriched with cream for a warm and comforting culinary experience.", 'd3.jpg'],
            ['Strawberry Cake', 2500.00, 'Desserts', "RFC Strawberry Cake: Moist layers of cake infused with fresh strawberry flavor, a delightful and fruity dessert.", 'd4.jpg'],
            ['Bamboo Pittu', 500.00, 'Desserts', "RFC Bamboo Pittu: A traditional Sri Lankan dish, steamed rice and coconut mixture cooked in bamboo, a unique culinary delight.", 'd5.jpg'],
            ['String Hoppers', 585.00, 'Desserts', "RFC String Hoppers: Thin rice noodles steamed to perfection, a popular Sri Lankan dish often served with various curries.", 'd6.jpg'],
            ['Coke', 150.00, 'Beverages', "RFC Coke: A well-known carbonated soft drink, enjoyed for its sweet and refreshing taste worldwide.", 'b1.jpg'],
            ['Fanta', 150.00, 'Beverages', "RFC Fanta: A popular carbonated fruit-flavored soft drink known for its vibrant and refreshing taste.", 'b2.jpg'],
            ['Sprite', 350.00, 'Beverages', "RFC Sprite: A popular lemon-lime flavored carbonated soft drink, renowned for its crisp and refreshing taste.", 'b3.jpg'],
            ['Green Apple Juice', 450.00, 'Beverages', "RFC Green Apple Juice: Freshly pressed apples, a crisp and refreshing juice bursting with green apple flavor.", 'b4.jpg'],
            ['Orange Juice', 460.00, 'Beverages', "RFC Orange Juice: Freshly squeezed oranges, a tangy and invigorating juice filled with the natural essence of oranges.", 'b5.jpg'],
            ['Lemon Juice', 330.00, 'Beverages', "RFC Lemon Juice: Freshly squeezed lemons, a zesty and refreshing juice with the natural tartness of lemons.", 'b6.jpg'],
            ['Mineral Water', 160.00, 'Beverages', "RFC Mineral Water: Purified, natural spring water with essential minerals, a refreshing and hydrating beverage choice.", 'b7.jpg'],
            ['Papaya Juice', 270.00, 'Beverages', "RFC Papaya Juice: Freshly blended papayas, a tropical and rejuvenating juice filled with the natural sweetness of papaya.", 'b8.jpg'],
            ['Watermelon Juice', 220.00, 'Beverages', "RFC Watermelon Juice: Juicy, ripe watermelons, a hydrating and refreshing juice bursting with the natural sweetness of watermelon.", 'b9.jpg'],
        ];

        foreach ($products as [$name, $price, $cat, $desc, $img]) {
            Product::updateOrCreate(
                ['item_name' => $name],
                ['price' => $price, 'category' => $cat, 'description' => $desc, 'image' => $img]
            );
        }
    }
}
