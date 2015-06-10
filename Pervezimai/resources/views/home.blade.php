@extends('app')

@section('content')

<div id="fb-root"></div>
<script>
	window.fbAsyncInit = function() {
        FB.init({
          appId      : '464348437061473',
          xfbml      : true,
          version    : 'v2.3'
        });
      };

	(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/lt_LT/sdk.js#xfbml=1&version=v2.3";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>

<div class="container">
	<div class="row">
		<div class="well well-lg text-center">
            <h2>Informacinė pervežimų sistema Nuvežk.lt</h2>
        </div>
	</div>

	<style type="text/css">
		.fb-page, 
		.fb-page span, 
		.fb-page span iframe[style] { 
    		width: 100% !important; 	
		}
		.row-centered{
			vertical-align: middle;
		}
		html > body > .conteiner > .row.row-centered > .like_it > .fb-page.fb_iframe_widget > span > iframe > #facebook > body > .li > div > div#u_0_0 > div{
			margin: 0 auto !important; 
		}
		/*.like_it{
			margin-left: auto;
   			margin-right: auto; 
		}*/
	</style>

	<div class="row row-centered">
		<div style="min-width: 280px; width: 500px; margin: 0 auto;" id="u_0_0">
			<div class="fb-page" data-href="https://www.facebook.com/pages/Nuvezklt/471235706362969" data-width="2000" 
			data-hide-cover="false" data-show-facepile="true" data-show-posts="true">
				<div class="fb-xfbml-parse-ignore">
					<blockquote cite="https://www.facebook.com/pages/Nuvezklt/471235706362969">
						<a href="https://www.facebook.com/pages/Nuvezklt/471235706362969">Nuvezk.lt</a>
					</blockquote>
				</div>
			</div>
		</div>
	</div>

        @if (Session::has('activation'))
            <div class="alert {{ Session::has('activation_resend') ? 'alert-info' : 'alert-success' }}">
                {{ session('activation') }}
            </div>
        @endif
        @if (Session::has('activation_error'))
            <div class="alert alert-danger">
                {{ session('activation_error') }}
            </div>
        @endif
</div>
@endsection

@section('footer')
    <script>
        $('div.alert').not('.alert-danger').delay(5000).slideUp(300);
    </script>
@endsection
