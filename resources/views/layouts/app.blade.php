<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Taktek</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

  <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
  <script src="{{asset('js/toastr.min.js')}}"></script>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">


  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      color: #333;
    }


    .grey-bg{
    background-color: #777777;
}
.blue-bg{
    background-color: #41A5F3;
}
.green-bg{
    background-color: #12D1B7;
}

.warning-bg{
    background-color: #f8aa44 !important;
}
.red-text{
  color: red;
}
   
  </style>
    @livewireStyles
    
</head>
<body>

  {{-- <!-- Header -->
  <header>
    <nav>
      <a href="#">Home</a>
      <a href="#">About</a>
      <a href="#">Contact</a>
    </nav>
  </header> --}}


  <div class="container-fluid" style="margin-top: 100px">
    @yield('body')

    @livewire('author-items')
  </div>


  
  @livewireScripts
  @livewire('livewire-ui-modal')

  <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script>
  window.addEventListener('swal:modal', event => { 

    swal({


      text: event.detail.text,

    });

});
</script> 
  
  {{-- <script>
    window.addEventListener('alert', event => {
        alert(event);
        toastr[event.detail.type](event.detail.message,
            event.detail.title ?? '');
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
        }
    })
</script> --}}
  <script>
    var progressbar = $('.progress-bar');

    document.addEventListener('livewire-upload-finish', () => {
        progressbar.hide();
    });
    document.addEventListener('livewire-upload-error', () => {
        progressbar.addClass('bg-danger');
    });
    document.addEventListener('livewire-upload-progress', (event) => {
        progressbar.css('width', event.detail.progress + "%");
        if (event.detail.progress > 30 && event.detail.progress < 50) {
            progressbar.addClass('blue-bg');
        } else if (event.detail.progress > 50) {
            progressbar.removeClass('blue-bg');
            progressbar.addClass('green-bg');
        }
        progressbar.text(event.detail.progress + "%");
    });
</script>

<script>
  toastr.options.showMethod = 'slideDown';
  toastr.options.closeButton = true;
  toastr.options.progressBar = true;
  window.addEventListener('showsuccess', event => {
      toastr.success(event.detail[0].title, event.detail[0].message)
  });
  window.addEventListener('showerror', event => {
      toastr.error(event.detail[0].title, event.detail[0].message)
  });
  window.addEventListener('showwarning', event => {
      toastr.warning(event.detail[0].title, event.detail[0].message)
  });
</script>
</body>
</html>