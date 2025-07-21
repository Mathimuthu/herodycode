<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sponsorship Form</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<style>
   body {
    background-image: url('https://herody.in/assets/digital/assets/img/hero/hero-bg-three.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
  }
</style>
<body class="font-[Inter] min-h-screen">

  <!-- Header with Blue Gradient -->
<header class="">
   <div class="topbar py-2 px-3 text-center" style="background-color: #001f3f;" style="font-family: 'Poppins', sans-serif;">
  <p class="mb-0 small text-white">Let's make something great together.</p>
</div>


    <div class="max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-6 py-4 text-white">

      <!-- Logo -->
      <div class="h-16 sm:h-20">
        <a href="#">
         <img src="{{ asset('assets/digital/assets/img/logo.png') }}" alt="Herody" class="w-12 h-12 sm:w-16 sm:h-16"> 
        </a>
      </div>

      <!-- Nav Links -->
     <nav class="hidden sm:flex space-x-4 sm:space-x-6 text-sm sm:text-base text-black font-bold" style="font-family: 'Poppins', sans-serif;">
  <a href="https://herody.in/" class="hover:text-blue-200 transition">Home</a>
  <a href="#" class="hover:text-blue-200 transition">Contact Us</a>
  <a href="#" class="hover:text-blue-200 transition">Sponsorship</a>
</nav>

      <!-- Mobile Menu Button -->
<button id="mobileMenuBtn" class="sm:hidden focus:outline-none bg-blue-900 text-white p-2 rounded">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="sm:hidden from-blue-100 via-blue-300 to-blue-700 px-4 pb-4 hidden">
      <nav class="space-y-2 font-medium">
        <a href="https://herody.in/" class="block py-2 hover:text-blue-200 transition">Home</a>
        <a href="#" class="block py-2 hover:text-blue-200 transition">Contact Us</a>
        <a href="#" class="block py-2 hover:text-blue-200 transition">Sponsorship</a>
      </nav>
    </div>
  </header>

@if(session('success'))
  <div class="max-w-4xl mx-auto mt-4 sm:mt-6 px-4 sm:px-0">
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md shadow-sm">
      {{ session('success') }}
    </div>
  </div>
@endif

  <!-- Heading -->
  <div class="max-w-4xl mx-auto px-4 text-black mt-0 text-sm sm:text-base leading-relaxed font-[Inter]">
  <h2 class="text-2xl sm:text-4xl font-bold mb-4 text-center">Sponsorship Form</h2>

  <p class="mb-4 text-center">
    If you are a college student and part of any Team/Society/ Clubs and want to raise the funds for the events and your regular society activities,
    you can start working with Herody on multiple task-based <b>cash</b> sponsorships.
  </p>

  <h3 class="font-semibold mb-2">Tasks that Work on with us:</h3>
  <ul class="list-disc list-inside mb-4 ml-4">
    <li>User Acquisition</li>
    <li>Brand Promotion & Social Media</li>
    <li>Fun Event Based Sponsorships</li>
    <li>Webinars & much more based on requirements.</li>
  </ul>

  <!--<h3 class="font-semibold mb-2">More Benefits:</h3>-->
  <!--<ul class="list-disc list-inside mb-4 ml-4">-->
  <!--  <li>Get multiple sponsorship opportunities</li>-->
  <!--  <li>Timely Payments</li>-->
  <!--  <li>Work With Multiple Companies</li>-->
  <!--</ul>-->

<!-- <h3 class="font-semibold mb-2">Herody Sponsorships</h3>-->
<!--  <p class="mb-2"><strong>Our App:</strong> <a href="https://play.google.com/store/apps/details?id=com.jaketa.herody" class="text-blue-600 underline">https://play.google.com/store/apps/details?id=com.jaketa.herody</a></p>-->
<!--  <p class="mb-2"><strong>Community:</strong> <a href="https://chat.whatsapp.com/ELoNCt4qnck36kW2ISZXPN?mode=r_t" class="text-blue-600 underline">https://chat.whatsapp.com/ELoNCt4qnck36kW2lSZXPN?mode=r_t</a></p>-->
<!--  <p><strong>LinkedIn:</strong> <a href="https://www.linkedin.com/company/herody" class="text-blue-600 underline">https://www.linkedin.com/company/herody</a></p>-->
<!--</div>-->


  <!-- Form -->
<form method="POST" action="{{ route('sponsorship.store') }}" class="max-w-4xl mx-auto bg-white p-6 sm:p-8 mt-6 sm:mt-8 mb-12 sm:mb-16 rounded-md shadow-md mx-4 sm:mx-auto">
  @csrf
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
      <label class="block mb-1 font-medium">Your Full Name* :</label>
      <input type="text" name="full_name" class="w-full border border-blue-500 rounded-md p-2" placeholder="Enter Full Name" required>
    </div>
    <div>
      <label class="block mb-1 font-medium">College Name* :</label>
      <input type="text" name="college_name" class="w-full border border-blue-500 rounded-md p-2" placeholder="Enter College name" required>
    </div>
    <div>
      <label class="block mb-1 font-medium">City* :</label>
      <input type="text" name="city" class="w-full border border-blue-500 rounded-md p-2" placeholder="Enter City" required>
    </div>
    <div>
      <label class="block mb-1 font-medium">Contact Number* :</label>
      <input type="text" name="contact_number" class="w-full border border-blue-500 rounded-md p-2" placeholder="10 Digit Number" required>
    </div>
    <div>
      <label class="block mb-1 font-medium">Email ID* :</label>
      <input type="email" name="email" class="w-full border border-blue-500 rounded-md p-2" placeholder="Enter Email" required>
    </div>
  </div>

  <!-- Club / Society Radio -->
  <div class="mt-6">
    <label class="block font-medium mb-2">Are you part of any club or society?</label>
    <div class="flex flex-col sm:flex-row gap-2 sm:gap-4">
      <label><input type="radio" name="is_club_member" value="0" onclick="toggleClubFields(false)" class="mr-1"> No</label>
      <label><input type="radio" name="is_club_member" value="1" onclick="toggleClubFields(true)" class="mr-1"> Yes</label>
    </div>
  </div>

  <!-- Club Fields -->
  <div id="clubFields" class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 hidden">
    <div>
      <label class="block mb-1 font-medium">Club / Society Name* :</label>
      <input type="text" name="club_name" class="w-full border border-blue-500 rounded-md p-2" placeholder="Enter club / society name">
    </div>
    <div>
      <label class="block mb-1 font-medium">Your Position* :</label>
      <input type="text" name="position" class="w-full border border-blue-500 rounded-md p-2" placeholder="Enter your position in club/society">
    </div>
  </div>

  <!-- Upcoming Event Radio -->
  <div class="mt-6">
    <label class="block font-medium mb-2">Do you have any upcoming event?</label>
    <div class="flex flex-col sm:flex-row gap-2 sm:gap-4">
      <label><input type="radio" name="has_upcoming_event" value="0" onclick="toggleEventFields(false)" class="mr-1"> No</label>
      <label><input type="radio" name="has_upcoming_event" value="1" onclick="toggleEventFields(true)" class="mr-1"> Yes</label>
    </div>
  </div>

  <!-- Event Fields -->
  <div id="eventFields" class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 hidden">
    <div>
      <label class="block mb-1 font-medium">Event Name* :</label>
      <input type="text" name="event_name" class="w-full border border-blue-500 rounded-md p-2" placeholder="Enter event name">
    </div>
    <div>
      <label class="block mb-1 font-medium">Category* :</label>
      <select name="event_category" class="w-full border border-blue-500 rounded-md p-2">
        <option value="">Select a category</option>
        <option value="Technical">Technical</option>
        <option value="Cultural">Cultural</option>
        <option value="Sports">Sports</option>
      </select>
    </div>
    <div>
      <label class="block mb-1 font-medium">Expected Attendance :</label>
      <input type="number" name="expected_attendance" class="w-full border border-blue-500 rounded-md p-2" placeholder="Number of attendees">
    </div>
    <div>
      <label class="block mb-1 font-medium">Date :</label>
      <input type="date" name="event_date" class="w-full border border-blue-500 rounded-md p-2">
    </div>
    <div class="md:col-span-2">
      <label class="block mb-1 font-medium">Expected Sponsorship Amount :</label>
      <input type="text" name="expected_sponsorship" class="w-full border border-blue-500 rounded-md p-2" placeholder="Amount">
    </div>
  </div>

  <!-- Submit -->
  <div class="text-center mt-8">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md">
      Submit
    </button>
  </div>
</form>

<footer class="mt-16 bg-white text-black pt-12 pb-6">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <!-- Footer Top Area -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-10">
      <!-- About Herody -->
      <div>
        <h4 class="text-2xl font-semibold mb-4">About <span class="text-orange-400">Herody</span></h4>
        <p class="mb-4 text-sm leading-relaxed">
          Herody helps brands to scale their business by breaking down their complex business requirements into tasks and by taking end-to-end execution.
        </p>
         <img src="{{ asset('assets/digital/assets/img/logo.png') }}" alt="Herody" class="w-16 h-16"> 
                 <!--<img src="logo.png" alt="Herody" class="w-16 h-16">-->

      </div>

      <!-- Contact Us -->
      <div>
        <h4 class="text-2xl font-semibold mb-4">Contact Us</h4>
        <div class="mb-4 text-sm flex items-start gap-2">
          <i class="fa-solid fa-location-dot mt-1"></i>
          <p>
            4th Floor, Classic Converge, 17th Cross Road,<br>
            Sector 6, HSR Layout, Bengaluru, Karnataka 560102.
          </p>
        </div>
        <div class="text-sm flex items-center gap-2">
          <i class="fa-solid fa-envelope"></i>
          <p>help@herody.in</p>
        </div>
      </div>

      <!-- Businesses -->
      <div>
        <h4 class="text-2xl font-semibold mb-4">Businesses</h4>
        <p class="text-sm mb-4">
          For any business related queries reach us out at <strong>raj@herody.in</strong>
        </p>
        <ul class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4 text-xl">
          <li><span class="text-sm">Follow Us:</span></li>
          <li class="flex gap-4">
            <a href="https://www.facebook.com/herodywebsite" class="hover:text-blue-400"><i class="fa-brands fa-facebook-square"></i></a>
            <a href="https://www.instagram.com/herodyapp/" class="hover:text-pink-400"><i class="fa-brands fa-instagram-square"></i></a>
            <a href="https://www.linkedin.com/company/herody/" class="hover:text-blue-300"><i class="fa-brands fa-linkedin"></i></a>
          </li>
        </ul>
      </div>
    </div>

    <!-- Copyright -->
    <div class="border-t border-gray-700 mt-10 pt-6 text-center text-sm text-black">
      © 2025 <a href="https://herody.in" class="hover:text-white">Jaketa Media & Entertainment Private Limited</a>. All Rights Reserved.
    </div>
  </div>
</footer>

  <!-- Scripts -->
  <script>
    // Mobile menu toggle
    document.getElementById('mobileMenuBtn').addEventListener('click', function() {
      const mobileMenu = document.getElementById('mobileMenu');
      mobileMenu.classList.toggle('hidden');
    });

    function toggleClubFields(show) {
      document.getElementById('clubFields').classList.toggle('hidden', !show);
    }
    function toggleEventFields(show) {
      document.getElementById('eventFields').classList.toggle('hidden', !show);
    }
  </script>

</body>
</html>