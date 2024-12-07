<!DOCTYPE html>
<html lang="en">
  
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Basado Food&Drink
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Alkalami&family=Allerta&display=swap" rel="stylesheet">
  <style>
   body {
            font-family: 'Roboto', sans-serif;
        }
  </style>
  
  <style>
        .landing-custom {
            background-color: rgba(2, 62, 138, 0.65) ;
        }
  </style>
  <style>
        .font-alkalami {
            font-family: 'Alkalami', cursive;
        }

        .font-allerta {
            font-family: 'Allerta', sans-serif;
        }
  </style>
 </head>
 
 <body class="landing-custom text-gray-900">
  <!-- Header -->
  <header class="bg-white-900 shadow-md">
   <div class="container mx-auto flex justify-between items-center py-4 px-6">
   <div class="flex items-start ">
    <img alt="Member icon" class="w-32 h-30" height="100" src="/logobasado1ktmr.png" width="150" />
    <!-- <span class="text-white text-lg">
        Cek Member
    </span> -->
</div>
    <!-- <nav class="flex space-x-6">
     <a class="text-orange-500 font-bold" href="#">
      Home
     </a>
     <a class="text-gray-700" href="#">
      About
     </a>
     <a class="text-gray-700" href="#">
      Coffee
     </a>
     <a class="text-gray-700" href="#">
      Menu
     </a>
     <a class="text-gray-700" href="#">
      News
     </a>
    </nav> -->
    <div class="flex items-center space-x-2 border border-white p-2 rounded">
    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
        <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
    </svg>
    <a href="{{ route('member.search') }}" class="text-black text-lg">
        Cek Member
    </a>
</div>

  </header>
  <!-- Hero Section -->
  <section class="bg-gray-100 py-20">
   <div class="container mx-auto text-center">
    <h1 class="text-4xl font-bold mb-4">
     Good Coffee Will Always Find The Audience
    </h1>
    <p class="text-lg mb-8">
     We provide a variety of unique and Best Coffees
    </p>
    <!-- <a class="bg-orange-500 text-white py-3 px-6 rounded-full" href="#">
     Order Now
    </a> -->
   </div>
  </section>
  <!-- Features Section -->
  <section class="bg-blue-950 text-white py-12">
   <div class="container mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
    <div>
     <i class="fas fa-mug-hot text-4xl mb-4">
     </i>
     <h3 class="text-xl font-bold mb-2">
      Awesome Aroma
     </h3>
     <p>
      A great coffee aroma is a result of proper roasting and the selection of high-quality coffee beans.
     </p>
    </div>
    <div>
     <i class="fas fa-star text-4xl mb-4">
     </i>
     <h3 class="text-xl font-bold mb-2">
      High Quality
     </h3>
     <p>
     Coffee originating from the best coffee-producing regions tends to have higher quality.
     </p>
    </div>
    <div>
     <i class="fas fa-leaf text-4xl mb-4">
     </i>
     <h3 class="text-xl font-bold mb-2">
      Pure Grades
     </h3>
     <p>
     The grade of coffee indicates the quality and characteristics of the coffee beans.
     </p>
    </div>
    <div>
     <i class="fas fa-fire text-4xl mb-4">
     </i>
     <h3 class="text-xl font-bold mb-2">
      Proper Roasting
     </h3>
     <p>
     The roasting process is very important to bring out the best flavor of the coffee beans.
     </p>
    </div>
   </div>
  </section>

<!-- Experience the Magic of Basado Section -->
<section class="bg-gray-100 py-12">
    <div class="container mx-auto flex flex-col md:flex-row items-center">
        <!-- Text Section -->
        <div class="md:w-1/2 md:pr-8">
            <h2 class="text-4xl font-bold text-gray-800 mb-6" style="font-family: 'Playfair Display', serif;">
                Experience the Magic of Basado Food & Drink
            </h2>
            <p class="text-gray-600 text-lg mb-4">
                Welcome to Basado, where food and drink become an art form. From the moment you step in, you’re greeted with a warm and inviting atmosphere designed to make you feel at home.
            </p>
            <p class="text-gray-600 text-lg mb-4">
                Our carefully curated menu showcases a variety of dishes, each crafted with the freshest ingredients and a passion for culinary excellence. Whether it's a quick coffee, a hearty lunch, or an indulgent dessert, we have something for everyone.
            </p>
            <p class="text-gray-600 text-lg mb-6">
                Let Basado be your daily escape. Come for the food, stay for the memories.
            </p>
        </div>
        <!-- Image Section -->
        <div class="md:w-1/2 mt-8 md:mt-0">
            <img src="/basadoolandingpage.jpg" alt="Basado Experience" class="rounded-lg shadow-lg">
        </div>
    </div>
</section>



<!-- Top Products Section -->

<section class="bg-white py-12">
    <div class="container mx-auto text-center">
        <h2 class="text-4xl font-bold mb-8">Top 10 Best-Selling Products</h2>

        {{-- Pesan error jika ada --}}
        @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- Tampilkan data produk jika ada --}}
        @if (!empty($produks) && $produks->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
                @foreach ($produks as $produk)
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <img 
                            src="{{ asset($produk->foto_produk) }}" 
                            alt="{{ $produk->nama_produk }}" 
                            class="w-full h-60 object-cover mb-4 rounded-lg">
                        <h3 class="text-xl font-bold mb-2">{{ $produk->nama_produk }}</h3>
                        <p class="text-xl font-bold mb-4 text-blue-400">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>               
        @else
            {{-- Pesan jika data kosong --}}
            <p class="text-gray-500">Tidak ada produk yang ditemukan untuk bulan ini.</p>
        @endif
    </div>
</section>

<!-- Best Coffee House Section -->
<section class="bg-gray-100 py-12">
    <div class="container mx-auto flex flex-col md:flex-row items-center">
     <div class="md:w-1/2">
      <img alt="Coffee Shop Image" class="rounded-lg shadow-lg" height="400" src="/basadolandingpage1.jpg" width="600"/>
     </div>
     <div class="md:w-1/2 md:ml-8 mt-8 md:mt-0">
      <h2 class="text-3xl font-bold mb-4" style="font-family: 'Allerta', sans-serif;">
       <!-- Best Coffee House In Your Home Town -->
       Craving something new?
       Pair your coffee with one of our signature dishes.
      </h2>
      <p class="mb-4">
      Discover a unique dining experience at Basado Food and Drink. Enjoy our cozy atmosphere while savoring our carefully selected coffee and authentic dishes that will tantalize your taste buds..
      </p>
      <p class="mb-4">
      Each dish is a perfect blend of high-quality ingredients and our chef's creative touch. Come and experience the culinary journey you'll never forget.
      </p>
      <!-- <a class="bg-orange-500 text-white py-3 px-6 rounded-full" href="#">
       Read More
      </a> -->
     </div>
    </div>
</section>
  <!-- Subscribe Section -->
  <!-- <section class="bg-gray-900 text-white py-12">
   <div class="container mx-auto flex flex-col md:flex-row items-center">
    <div class="md:w-1/2">
     <img alt="Coffee Beans Heart" class="rounded-lg shadow-lg" height="400" src="https://storage.googleapis.com/a1aa/image/2mej5wcSCgTQVqMysQHOfGT8F84MOLd0gptHewChZVA0pwZnA.jpg" width="600"/>
    </div>
    <div class="md:w-1/2 md:ml-8 mt-8 md:mt-0 text-center md:text-left">
     <h2 class="text-3xl font-bold mb-4">
      Subscribe To Get News
     </h2>
     <form class="flex flex-col md:flex-row items-center">
      <input class="w-full md:w-auto p-3 rounded-lg text-gray-900 mb-4 md:mb-0 md:mr-4" placeholder="Enter Your Email" type="email"/>
      <button class="bg-orange-500 text-white py-3 px-6 rounded-full" type="submit">
       Subscribe
      </button>
     </form>
    </div>
   </div>
  </section> -->
  <!-- Footer -->
  <footer class="bg-blue-950 text-white py-12">
   <div class="container mx-auto flex flex-col md:flex-row justify-between text-center md:text-left space-y-8 md:space-y-0">
      <!-- Logo Basado di kiri -->
      <div class="flex flex-col items-center md:items-start">
         <div class="text-left mb-4">
            <img src="/logobasado1ktmr.png" alt="Logo Basado food&amp;drink" class="w-32 h-30" width="250" height="100"/>
         </div>
      </div>

      <!-- Contact Us di tengah -->
      <div class="flex flex-col items-center md:items-center">
         <h3 class="text-xl font-semibold mb-4" style="font-family: 'Allerta', sans-serif;">
          Contact Us</h3>
         <p>Address: Jalan Sadar Tugu Nenas, Pasar Siborongborong</p>
         <p>Phone number: (+62) 83867685577</p>
         <p>Email: basadofnd@gmail.com</p>
      </div>

      <!-- Viewer Guides di kanan -->
      <div class="flex flex-col items-center md:items-start">
         <h3 class="text-xl font-semibold mb-4" style="font-family: 'Allerta', sans-serif;">
          Viewer Guides</h3>
         <ul>
            <li><a href="#" class="text-gray-400">About</a></li>
            <li><a href="#" class="text-gray-400">Coffee</a></li>
         </ul>
      </div>
   </div>

   <div class="container mx-auto mt-8 text-center">
    <hr>
      <p class="font-allerta">
      Looking for the perfect place to unwind? Our cozy atmosphere and delicious food will make you feel right at home. 
      </p>
    </hr>
   </div>
</footer>
</html>