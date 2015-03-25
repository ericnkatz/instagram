<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Civic Hacks</title>

  <!-- toolkit styles -->
  <link rel="stylesheet" href="/css/toolkit.css">
  <!-- /toolkit styles -->

</head>
<body>


<div class="container -centered">
    <div class="container -centered">
      @foreach($images as $image)
        <div class="instagram">
          <div class="instagram__users js-insert-avatars">
            <div class="instagram__users__user user">
              <div class="user__avatar">
                <div class="intrinsic full">
                  <div class="intrinsic__wrapper -ratio-1x1">
                    <img class="intrinsic__wrapper__element" src="{{ $image['avatar'] }}" alt="{{ $image['username'] }}" />
                  </div>
                </div>
              </div>
              <h2 class="user__name">
                {{ $image['username'] }}
              </h2>
            </div>
          </div>
          <div class="instagram__image js-insert-image">
              <img class="full" src="{{ $image['image'] }}" alt="" />
          </div>
        </div>
        <?php break; ?>
      @endforeach
    </div>
</div>



<script src="/js/jquery.js"></script>
<script src="/js/lodash.js"></script>
{{-- <script src="/js/main.js"></script> --}}
<script src="//js.pusher.com/2.2/pusher.min.js" type="text/javascript"></script>
<script type="text/javascript">

    // Enable pusher logging - don't include this in production
    Pusher.log = function(message) {
      if (window.console && window.console.log) {
        window.console.log(message);
      }
    };

    var pusher = new Pusher('c5bb52c4f0cc67c69acb');
    var channel = pusher.subscribe('{{ $tag }}');
    channel.bind('add_image', function(data) {
      console.log(data);
    });
  </script>


</body>
</html>