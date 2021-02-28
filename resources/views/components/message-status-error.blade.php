@props(['status'])

@if ($status)
<div class="py-3">
   <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
       <div class="flex items-center overflow-hidden shadow-sm sm:rounded-lg  m-auto ">
           <div class="px-10 py-4 bg-red-100 border-2 rounded border-gray-400 m-auto ">
               <h2 class="font-bold text-xl text-red-600">{{ $status }}</h2>
           </div>
       </div>
   </div>
</div>
{{-- 
<div class="px-4 py-3 leading-normal text-blue-700 bg-blue-100 rounded-lg" role="alert">
   <p> {{ $status }}</p>
 </div> --}}
@endif