<div id="social-auth">
    <button id="facebook-auth" onclick="window.location.href = '{{ route('login.facebook') }}'" type="button">
        <i class="lni-facebook-original"></i>
        {{ $title }} with Facebook
    </button>
    <button id="google-auth" onclick="window.location.href = '{{ route('login.google') }}'" type="button">
        <img src="/images/google.png" width="15" height="15">
        {{ $title }} with Google
    </button>
</div>