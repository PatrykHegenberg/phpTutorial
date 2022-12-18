<!DOCTYPE html>
<html lang="de" class="h-full bg-gray-100">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Demo</title>
  <style>
    * {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      background-color: #33adee;
    }

    .container {
      background-color: #ffffff;
      width: 90%;
      max-width: 31.25em;
      position: absolute;
      transform: translate(-50%, -50%);
      top: 50%;
      left: 50%;
      padding: 5em 3em;
      border-radius: 0.5em;
    }

    .container h3 {
      font-size: 1.2em;
      color: #23234c;
      text-align: center;
      font-weight: 500;
      line-height: 1.8em;
    }

    .container #submit-btn {
      font-size: 1.2em;
      font-weight: 500;
      display: block;
      margin: 0 auto;
      background-color: #33adee;
      border-radius: 0.3em;
      border: none;
      outline: none;
      cursor: pointer;
      color: #1d1d20;
      padding: 0.6em 2em;
    }

    #error-msg {
      text-align: center;
      margin-top: 1em;
      background-color: #ffdde0;
      color: #d62f2f;
      padding: 0.2em 0;
    }

    .container #question {
      background-color: #eeedf1;
      font-size: 2em;
      font-weight: 600;
      color: #23234c;
      text-align: center;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 1.4em 0 1em 0;
      padding: 1em 0;
    }

    .container input {
      font-size: 1em;
      font-weight: 600;
      width: 2.35em;
      color: #23234c;
      text-align: center;
      padding: 0 0.2em;
      border: none;
      background-color: transparent;
      border-bottom: 0.12em solid #23234c;
      margin: 0 0.25em;
    }

    .container input:focus {
      border-color: #33adee;
      outline: none;
    }

    /*Hide Number Arrows*/
    .container input[type="number"] {
      -moz-appearance: textfield;
    }

    .container input[type="number"]::-webkit-outer-spin-button,
    .container input[type="number"]::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    .controls-container {
      position: absolute;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      background-color: #33adee;
      height: 100%;
      width: 100%;
      top: 0;
    }

    #start-btn {
      font-size: 1.2em;
      font-weight: 500;
      background-color: #ffffff;
      color: #23234c;
      border: none;
      outline: none;
      cursor: pointer;
      padding: 0.8em 1.8em;
      border-radius: 0.3em;
    }

    #result {
      margin-bottom: 1em;
      font-size: 1.5em;
      color: #23234c;
    }

    #result span {
      font-weight: 600;
    }

    .hide {
      display: none;
    }
  </style>
</head>

<body class="h-full">
  <div class="min-h-full">
    <?php require('partials/nav.php') ?>
    <?php require('partials/banner.php') ?>
    <main>
      <div class="flex flex-col mx-auto text-center max-w-7xl py-6 sm:px-6 lg:px-8 container">
          <h3>Schreibe die richtige Zahl in die Lücke</h3>
          <div id="question"></div>
          <button id="submit-btn">Bestätigen</button>
          <p id="error-msg">Da gab es einen Fehler</p>
        </div>
        <div class="controls-container">
          <p id="result"></p>
          <button id="start-btn">Spiel starten</button>

        </div>
        <script>
          let operators = ["*"];
          const startBtn = document.getElementById("start-btn");
          const question = document.getElementById("question");
          const controls = document.querySelector(".controls-container");
          const result = document.getElementById("result");
          const submitBtn = document.getElementById("submit-btn");
          const errorMessage = document.getElementById("error-msg");
          let answerValue;
          let operatorQuestion;

          //Random Value Generator
          const randomValue = (min, max) => Math.floor(Math.random() * (max - min)) + min;

          const questionGenerator = () => {
            //Two random values between 1 and 20
            let [num1, num2] = [randomValue(1, 10), randomValue(1, 10)];

            //For getting random operator
            let randomOperator = operators[Math.floor(Math.random() * operators.length)];

            if (randomOperator == "-" && num2 > num1) {
              [num1, num2] = [num2, num1];
            }

            //Solve equation
            let solution = eval(`${num1}${randomOperator}${num2}`);

            //For placing the input at random position
            //(1 for num1, 2 for num2, 3 for operator, anything else(4) for solution)
            let randomVar = randomValue(1, 3);

            if (randomVar == 1) {
              answerValue = num1;
              question.innerHTML = `<input type="number" id="inputValue" placeholder="?"\> ${randomOperator} ${num2} = ${solution}`;
            } else if (randomVar == 2) {
              answerValue = num2;
              question.innerHTML = `${num1} ${randomOperator}<input type="number" id="inputValue" placeholder="?"\> = ${solution}`;
            } else if (randomVar == 3) {
              answerValue = randomOperator;
              operatorQuestion = true;
              question.innerHTML = `${num1} <input type="text" id="inputValue" placeholder="?"\> ${num2} = ${solution}`;
            } else {
              answerValue = solution;
              question.innerHTML = `${num1} ${randomOperator} ${num2} = <input type="number" id="inputValue" placeholder="?"\>`;
            }

            //User Input Check
            submitBtn.addEventListener("click", () => {
              errorMessage.classList.add("hide");
              let userInput = document.getElementById("inputValue").value;
              //If user input is not empty
              if (userInput) {
                //If the user guessed correct answer
                if (userInput == answerValue) {
                  stopGame(`Das war richtig!!`);
                }
                //If user inputs operator other than +,-,*
                else if (operatorQuestion && !operators.includes(userInput)) {
                  errorMessage.classList.remove("hide");
                  errorMessage.innerHTML = "Please enter a valid operator";
                }
                //If user guessed wrong answer
                else {
                  stopGame(`Ups!! Das war leider falsch.`);
                }
              }
              //If user input is empty
              else {
                errorMessage.classList.remove("hide");
                errorMessage.innerHTML = "Input Cannot Be Empty";
              }
            });
          };

          //Start Game
          startBtn.addEventListener("click", () => {
            operatorQuestion = false;
            answerValue = "";
            errorMessage.innerHTML = "";
            errorMessage.classList.add("hide");
            //Controls and buttons visibility
            controls.classList.add("hide");
            startBtn.classList.add("hide");
            questionGenerator();
          });

          //Stop Game
          const stopGame = (resultText) => {
            result.innerHTML = resultText;
            startBtn.innerText = "Weiter";
            controls.classList.remove("hide");
            startBtn.classList.remove("hide");
          };
        </script>
      </div>
    </main>
    <?php require('partials/footer.php') ?>