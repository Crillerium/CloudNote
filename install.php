<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Crillerium Note</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="style.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Rubik', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
      font-size: calc(10px + 0.33vw);
      -webkit-font-smoothing: antialiased;
      padding: 5vh 10vw;
      color: #121314;
    }
    h1 {
      font-size: 4.5em;
      font-weight: 500;
      margin-bottom: 0;
    }
    p {
      font-size: 1.6em;
      font-weight: 300;
      line-height: 1.4;
    }
    a {
      text-decoration: none;
      color: #121314;
      position: relative;
    }
    a:after {
      content: "";
      position: absolute;
      z-index: -1;
      top: 60%;
      left: -0.1em;
      right: -0.1em;
      bottom: 0;
      transition: top 200ms cubic-bezier(0, .8, .13, 1);
      background-color: rgba(79,192,141,0.5);
    }
    a:hover:after {
      top: 0%;
    }
    .comments {
    width:100%;/*自动适应父布局宽度*/
    overflow:auto;
    word-break:break-all;
    outline: none;
    }
    textarea{
      outline: none;
      resize: none;
    }
  </style>
</head>
<body>
  <h1>您好，</h1>
  <p style="font-weight:500; font-size:2.2em">
    马上开始使用Crillerium Note。
  </p>
  <p>
    已经编辑好server.config了吗?<br/>
    <a href="operate.php?action=install">开始安装!</a>
  </p>
</body>
</html>
