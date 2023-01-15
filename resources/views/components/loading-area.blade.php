@props(['background_color' => '#bbb'])
<div id="loading">
  <div class="wrapper">
    <div class="circlesWrapper">
      <div class="spinner"></div>
      <div class="circle circleHorizontal circle1"></div>
      <div class="circle circleHorizontal circle2"></div>
      <div class="circle circleHorizontal circle3"></div>
      <div class="circle circleHorizontal circle4"></div>
      <div class="circle circleHorizontal circle5"></div>
      <div class="circle circleHorizontal circle6"></div>
      <div class="circle circleVertical circle7"></div>
      <div class="circle circleVertical circle8"></div>
      <div class="circle circleVertical circle9"></div>
      <div class="circle circleVertical circle10"></div>
      <div class="circle circleVertical circle11"></div>
      <div class="circle circleVertical circle12"></div>
      <div class="mozi">Loading</div>
    </div>
    <div class="cover" style="background-color: {{ $background_color !== '#ffffff' ? $background_color : '#bbb' }};"></div>
  </div>
</div>