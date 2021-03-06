<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
        
            #won, #lost{
                text-align: center;
                display: none;
                padding-bottom:20px;
            }
            
            .hint{
              display: none;  
            }
            
            .hideHintBtn{
                display: none;
                color: #fff;
                background-color: #f0ad4e;
                border-color: #eea236;
                padding: 6px 12px;
                margin-bottom: 0;
                font-size: 14px;
                font-weight: 400;
                line-height: 1.42857143;
                text-align: center;
                white-space: nowrap;
                vertical-align: middle;
                border: 1px solid transparent;
                border-radius: 4px;
            }
            
            
            #word, #letters{
                padding: 20px 0px;
            }
            
            #man{
                margin: 20px auto;
                width: 600px;
                height: 600px;
                border: solid;
                border-radius: 5px;
                border-width: 1px;
            }
            
            #word{
                font-size: 1.8em;
            }
            .hint{
                font-size: 0.6em !important;
            }
            .btn{
                padding: 7px 7px !important;
                margin: 0px 2px;
            }
            
        </style>
        <title>Hangman</title>
        <link  href="css/styles.css" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        
    </head>
    <body>
        <div class='container text-center'>
            <header>
               <h1>Hangman</h1>
               <h4>JavaScript Edition</h4>
            </header>
            
            <div id="word"></div>
            <button class="hintBtn btn btn-warning">hint</button>
            <div id="letters">
                <!--<input type="text" name="letterBox"/>-->
                <!--<button id="letterBtn">Submit</button>-->
            </div>
            
            <div id="man">
               <img id="hangImg" src="./img/stick_0.png">
            </div>
        </div>
        <div id="won">
            <h2>You Won!</h2>
            <button class="replayBtn btn btn-success">Play Again</button>
        </div>
        <div id="lost">
            <h2>You Lost!</h2>
            <button class="replayBtn btn btn-warning">Play Again</button>
        </div>
        
        
        <script language="javascript">
            var hintShowing = false;
            var selectedWord = "";
            var selectedHint = "";
            var board = [];
            var remainingGuesses = 6;
            var words = [ {word: "snake", hint: "It's a reptile"},
                          {word: "monkey", hint: "It's a mammal"},
                          {word: "beetle", hint: "It's an insect"},
                          {word: "horse", hint: "It's a horse"},
                          {word: "whale", hint: "It's a whale"}];
                          
            var alphabet = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 
                'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 
                'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];


            // $("#letterBtn").click(function(){
            //     var boxVal = $("#letterBox").val();
            //     console.log("hi");
            // });
            
            function createLetters(){
                for(var letter of alphabet){
                    $("#letters").append("<button class='letter' id='" + letter + "'>" + letter + "</button>");
                }
            }
            
            function checkLetter(letter){
                var positions = new Array();
                
                for(var i = 0; i < selectedWord.length; i++){
                    console.log(selectedWord);
                    if(letter == selectedWord[i]){
                        positions.push(i);
                    }
                }
                
                if(positions.length > 0){
                    updateWord(positions, letter);
                    
                if(!board.includes("_")){
                    endGame(true);
                }
                }else{
                    remainingGuesses -= 1;
                    updateMan();
                }
                
                if(remainingGuesses <= 0){
                    endGame(false);
                }
            }
            
            window.onload = startGame();
            
            function updateWord(positions, letter){
                for(var pos of positions){
                    board[pos] = letter;
                }
                
                updateBoard();
            }
            
            function initBoard(){
                for(var letter in selectedWord){
                    board.push("_")
                }
            }
            
            function pickWord(){
                var randomInt = Math.floor(Math.random() * words.length);
                selectedWord = words[randomInt].word.toUpperCase();
                selectedHint = words[randomInt].hint;
            }
            
            function updateBoard(){
                $("#word").empty();
                
                for(var letter of board){
                    document.getElementById("word").innerHTML += letter + " ";
                }
                $("#word").append("<br />");
                $("#word").append("<span class='hint'>Hint: " + selectedHint + "</span><br>");
                $("#word").append("<button class='hideHintBtn'>hide hint</button>")
                if(!hintShowing){
                    $(".hint").show();
                    $(".hideHintBtn").show();
                    $(".hintBtn").hide();
                    hintShowing = true;
                }if(hintShowing){
                    $(".hint").hide();
                    $(".hideHintBtn").hide();
                    $(".hintBtn").show();
                    hintShowing = false;
                }
                
            }
            
            function updateMan(){
                $("#hangImg").attr("src", "./img/stick_" + (6 - remainingGuesses) + ".png");
                
            }
            
            function endGame(win){
                $("#letters").hide();
                
                if(win){
                    $("#won").show();
                }else{
                    $("#lost").show();
                }
            }
            
            function startGame(){
                pickWord();
                initBoard();
                createLetters();
                updateBoard();
            }
            
            function disableButton(btn){
                btn.prop("disabled", true);
                btn.attr("class", "btn btn-danger");
            }
            
            $(".letter").click(function(){
                checkLetter($(this).attr("id"));
                disableButton($(this));
            });
                
            $(".replayBtn").on("click", function(){
                location.reload();
            });
            
            $(".hintBtn").click(function(){
                if(!hintShowing){
                    $(".hint").show();
                    $(".hideHintBtn").show();
                    $(".hintBtn").hide();
                    hintShowing = true;
                }
            });
            $(".hideHintBtn").click(function(){
                if(hintShowing){
                    $(".hint").hide();
                    $(".hideHintBtn").hide();
                    $(".hintBtn").show();
                    hintShowing = false;
                }
            });
            
        </script>
        
        
    </body>
</html>