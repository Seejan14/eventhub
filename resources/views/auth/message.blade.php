<html>
<head>
    <title>Event Hub</title>
</head>
<body>
<style>
    body {
        background: rgba(96, 196, 196, .3);
        font-family: 'Open-sans', sans-serif;
    }
    .expired {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }

    .image{
        flex: 1;
    }
    

    .message {
        flex: 1;
    }
    .message h1 {
    color: #3698DC;
    font-size: 3vw !important;
    font-weight: 400;
    }
    .message p {
    color: #262C34;
    font-size: 1.3em;
    font-weight: lighter;
    line-height: 1.1em;
    }
    .light {
    position: relative;
    top: -36em;
    }
    .light_btm {
    position: relative;
    }
    .light span:first-child {
    display: block;
    height: 6px;
    width: 150px;
    position: absolute;
    top:5em;
    left: 20em;
    background: #fff;
    border-radius: 3px;
    /*   transform: rotate(40deg); */
    }
    .light span:nth-child(2) {
    display: block;
    height: 6px;
    width: 200px;
    position: absolute;
    top:6em;
    left: 19em;
    background: #fff;
    border-radius: 3px;
    /*   transform: rotate(40deg); */
    }
    .light span:nth-child(3) {
    display: block;
    height: 6px;
    width: 100px;
    position: absolute;
    top:7em;
    left: 24em;
    background: #fff;
    border-radius: 3px;
    /*   transform: rotate(40deg); */
    }

    .light_btm span:first-child {
    display: block;
    height: 6px;
    width: 150px;
    position: absolute;
    bottom:6em;
    right: 20em;
    background: #fff;
    border-radius: 3px;
    /*   transform: rotate(40deg); */
    }
    .light_btm span:nth-child(2) {
    display: block;
    height: 6px;
    width: 200px;
    position: absolute;
    bottom: 7em;
    right: 21em;
    background: #fff;
    border-radius: 3px;
    /*   transform: rotate(40deg); */
    }
    .light_btm span:nth-child(3) {
    display: block;
    height: 6px;
    width: 100px;
    position: absolute;
    bottom:8em;
    right: 24em;
    background: #fff;
    border-radius: 3px;
    /*   transform: rotate(40deg); */
    }
    .use-desktop {
    font-weight: 400;
    color: #3698DC;
    border: 1px solid white;
    height: 3.4em;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    border-radius: 25px;
    line-height: 1.1em;
    font-size: 5vw;
    }
    @media(max-width:772px)
    {
        .expired {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        }
    }

</style>
<div class="expired">
    <div class="image">
        <img src= "{{ asset('assets/img/logos/app.png') }}" style="height: 100%; width:100%" alt="">
    </div>
  
    <div class="message">
      {{-- <h1>Oops, this link is expired</h1> --}}
    @if(isset($title1))
        <h1>{{ $title1 }}</h1>
    @endif
    @if(isset($title2))
        <p>{{ $title2 }}</p>
    @endif
      
      <a href="{{ \config('app.website_url') }}" target="_blank">Go to Malla Treks</a>
    </div>
    
  <!--   <div class="light">
      <span></span>
      <span></span>
      <span></span>
    </div>
      <div class="light_btm">
      <span></span>
      <span></span>
      <span></span>
    </div> -->
</div>

</body>
</html>