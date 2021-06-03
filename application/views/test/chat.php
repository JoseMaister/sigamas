<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook like chat popup layout</title>
    <link href="style.css" rel="stylesheet">
    <style>

        body{
            background:#e5e5e5;
            font-family: sans-serif;
        }

        .msg_box{
            position:fixed;
            bottom:-5px;
            width:250px;
            background:white;
            border-radius:5px 5px 0px 0px;
        }

        .msg_head{ 
            background:black;
            color:white;
            padding:8px;
            font-weight:bold;
            cursor:pointer;
            border-radius:5px 5px 0px 0px;
        }

        .msg_body{
            background:white;
            height:200px;
            font-size:12px;
            padding:15px;
            overflow:auto;
            overflow-x: hidden;
        }

        .msg_input{
            width:100%;
            height: 55px;
            border: 1px solid white;
            border-top:1px solid #DDDDDD;
            -webkit-box-sizing: border-box; 
            -moz-box-sizing: border-box;   
            box-sizing: border-box;  
        }

        .close{
            float:right;
            cursor:pointer;
            }
            .minimize{
            float:right;
            cursor:pointer;
            padding-right:5px;
            
        }

        .msg-left{
            position:relative;
            background:#e2e2e2;
            padding:5px;
            min-height:10px;
            margin-bottom:5px;
            margin-right:10px;
            border-radius:5px;
            word-break: break-all;
        }

        .msg-right{
            background:#d4e7fa;
            padding:5px;
            min-height:15px;
            margin-bottom:5px;
            position:relative;
            margin-left:10px;
            border-radius:5px;
            word-break: break-all;
        }
    </style>
 <script src="jquery-1.10.1.min.js"></script>
 <script src="script.js"></script>
  </head>

<body>
<div class="msg_box" style="right:50px" rel="skp">
 <div class="msg_head">Sumit Kumar Pradhan
  <div class="close">x</div>
 </div>
 <div class="msg_wrap">
  <div class="msg_body">
   <div class="msg-left">What is up ? </div>
   <div class="msg-right">Playing video game, you say</div>
   <div class="msg-left">can i join you ? </div> 
   <div class="msg_push"></div>
  </div>
  <div class="msg_footer"><textarea class="msg_input" rows="4"></textarea></div>
 </div>
</div>
<div class="msg_box" style="right:310px;" rel="skp1" >
 <div class="msg_head">Amit Kumar Singh
  <div class="close">x</div>
 </div>
 <div class="msg_wrap">
  <div class="msg_body">
   <div class="msg-left">What is up ? </div>
   <div class="msg-right">Playing video game, you say</div>
   <div class="msg-left">can i join you ? </div> 
   <div class="msg_push"></div>
  </div>
  <div class="msg_footer"><textarea class="msg_input" rows="4"></textarea></div>
 </div>
</div>

<div class="msg_box" style="right:570px;" rel="skp2">
 <div class="msg_head">Neeraj Tiwari
  <div class="close">x</div>
 </div>
 <div class="msg_wrap" >
  <div class="msg_body" style="background-color: red;">
   <div class="msg-left">What is up ? </div>
   <div class="msg-right">Playing video game, you say</div>
   <div class="msg-left">can i join you ? </div> 
   <div class="msg_push"></div>
  </div>
  <div style="background-color: blue;" class="msg_footer"><text class="msg_input" rows="4"></textarea></div>
 </div>
</div>


<div class="msg_box" style="right:830px;" rel="skp3">
 <div class="msg_head">Sourav singh
  <div class="close">x</div>
  </div>
 <div class="msg_wrap">
  <div class="msg_body">
   <div class="msg-left">What is up ? </div>
   <div class="msg-right">Playing video game, you say</div>
   <div class="msg-left">can i join you ? </div> 
   <div class="msg_push"></div>
  </div>
  <div class="msg_footer"><textarea class="msg_input" rows="4"></textarea></div>
 </div>
</div>

<div class="msg_box" style="right:1090px;" rel="skp4">
 <div class="msg_head">Albert rod
  <div class="close">x</div>
 </div>
 <div class="msg_wrap">
  <div class="msg_body">
   <div class="msg-left">What is up ? </div>
   <div class="msg-right">Playing video game, you say</div>
   <div class="msg-left">can i join you ? </div> 
   <div class="msg_push"></div>
  </div>
  <div class="msg_footer"><textarea class="msg_input" rows="4"></textarea></div>
 </div>
</div>

</body>
</html>