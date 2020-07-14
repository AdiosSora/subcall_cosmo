<!DOCTYPE html>

<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Stable - ビデオ会議</title>
  <?php include('./header.php'); ?>
</head>
<body>
  <?php include('./nav.php'); ?>

  <div id="index-banner" class="parallax-container">
    <div class="container">
      <div class="section no-pad-bot">
        <br><br>
        <div class="row">
          <div class="col s12 m6 center">

            いいいいいいいいいいいいいいいいいいいいいいいいいい
          </div>
          <div class="col s12 m6 center">
            <div class="card-panel grey lighten-5">
            <form action="location.href("join.php")">
              <div class="input-field col s12">
                <input id="first_name" type="text" class="validate">
                <label for="ID">ID</label>
              </div>
              <div class="input-field col s12">
                <input id="password" type="password" class="validate">
                <label for="password">Password</label>
              </div>

              <input type="button" value="golink" onClick="golink()">
              <a class="" onclick="golink()">ログイン</a>
              <a class="waves-effect waves-light btn" onclick="room_make()">部屋を作る</a>
              <a class="waves-effect waves-light btn" onclick="clickBtn_create()" >部屋に入る</a>
              <a class="waves-effect waves-light btn">button</a>
              <input class="waves-effect waves-light btn" onclick="golink()">ログイン</button></br>
              <p id="p1">テスト１</p>
              <script>
                    //初期表示は非表示
                  document.getElementById("p1").style.display ="none";


                  function clickBtn_create(){
                  	const p1 = document.getElementById("p1");

                  	if(p1.style.display=="block"){
                  		// noneで非表示
                  		p1.style.display ="none";
                  	}else{
                  		// blockで表示
                  		p1.style.display ="block";
                  	}
                  }

              </script>
              <button type="button" onclick="room_in()">部屋に入る</button></br>
            </form>
              <div class="input-field col s12">
                <i class="material-icons prefix">textsms</i>
                <input type="text" id="autocomplete-input" class="autocomplete">
                <label for="autocomplete-input">Autocomplete</label>
              </div>
            </div>
          </div>
        </div>
        <div class="row center">
          <a href="http://materializecss.com/getting-started.html" id="download-button" class="btn-large waves-effect waves-light teal lighten-1">Get Started</a>
        </div>
        <br><br>

      </div>
    </div>
    <div class="parallax" style="background:#999999;"></div>
  </div>

  <div class="container">
    <div class="section">

      <!--   Icon Section   -->

      <div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons">flash_on</i></h2>
            <h5 class="center">Speeds up development</h5>

            <p class="light">We did most of the heavy lifting for you to provide a default stylings that incorporate our custom components. Additionally, we refined animations and transitions to provide a smoother experience for developers.</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons">group</i></h2>
            <h5 class="center">User Experience Focused</h5>

            <p class="light">By utilizing elements and principles of Material Design, we were able to create a framework that incorporates components and animations that provide more feedback to users. Additionally, a single underlying responsive system across all platforms allow for a more unified user experience.</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons">settings</i></h2>
            <h5 class="center">Easy to work with</h5>

            <p class="light">We have provided detailed documentation as well as specific code examples to help new users get started. We are also always open to feedback and can answer any questions a user may have about Materialize.</p>
          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="parallax-container valign-wrapper">
    <div class="section no-pad-bot">
      <div class="container">
        <div class="row center">
          <h5 class="header col s12 light">A modern responsive front-end framework based on Material Design</h5>
        </div>
      </div>
    </div>
    <div class="parallax" style="background:#999999;"></div>
  </div>

  <div class="container">
    <div class="section">

      <div class="row">
        <div class="col s12 center">
          <h3><i class="mdi-content-send brown-text"></i></h3>
          <h4>Contact Us</h4>
          <p class="left-align light">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam scelerisque id nunc nec volutpat. Etiam pellentesque tristique arcu, non consequat magna fermentum ac. Cras ut ultricies eros. Maecenas eros justo, ullamcorper a sapien id, viverra ultrices eros. Morbi sem neque, posuere et pretium eget, bibendum sollicitudin lacus. Aliquam eleifend sollicitudin diam, eu mattis nisl maximus sed. Nulla imperdiet semper molestie. Morbi massa odio, condimentum sed ipsum ac, gravida ultrices erat. Nullam eget dignissim mauris, non tristique erat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;</p>
        </div>
      </div>

    </div>
  </div>

  <div class="parallax-container valign-wrapper">
    <div class="section no-pad-bot">
      <div class="container">
        <div class="row center">
          <h5 class="header col s12 light">A modern responsive front-end framework based on Material Design</h5>
        </div>
      </div>
    </div>
    <div class="parallax" style="background:#999999;"></div>
  </div>

  <?php include('./footer.php'); ?>

  </body>
</html>
