<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RozetkaShop</title>

    {{-- bootstrap --}}
    <link rel="stylesheet" 
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" 
    integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Always expand</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarsExample02">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="{{route("main.index")}}">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Link</a>
                </li>
              </ul>
              <form class="form-inline my-2 my-md-0">
                @csrf
                <input class="form-control search-field" type="text" placeholder="Search">
              </form>
            </div>
          </nav>
    </header>
    <main>
        <div style="margin: 0% 8%">
            @yield('main_content')
        </div>
    </main>
    <footer>
        @yield('footer_content')
    </footer>
    {{-- bootstrap --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" 
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" 
    crossorigin="anonymous"></script> --}}
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" 
    crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script>
        let handleResult = function(response){
          console.log(response)
        }
        let setAjax = function(){
          let url = "search"
          let text = $('.search-field').val()
          let _token = $('input[name="_token"]').val();//searching <input name="_token"/>
          $.ajax({
            url: "{{ route('search')}}",
            type: "POST",
            data:{
              text: text,
              _token: _token
            },
            success: handleResult
          })
        }
        $(function(){
          $('.search-field').on('input', setAjax)
        })
    </script>
    <script>
        $(function(){
          if(pageScript != null)
          {
            pageScript()
          }
        })
    </script>
</body>
</html>