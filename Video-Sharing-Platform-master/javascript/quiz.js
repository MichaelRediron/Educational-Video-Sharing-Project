
/*var questions = [{
        question: "The sky is red",
        answers: {
            True: "True",
            False: "False"
        },
        correctAnswer: "False",
        wrongAnswer: "The correct answer is False"
    },
    {
        question: "The world is round.",
        answers: {
            True: "True",
            False: "False"
        },
        correctAnswer: "True",
        wrongAnswer: "The correct answer is True"
    },
    {
        question: "The world is flat.",
        answers: {
            True: "True",
            False: "False"
        },
        correctAnswer: "False",
        wrongAnswer: "The correct answer is False"
    }
];*/
var score = 0;

for (var i = 0; i < questions.length; i++) {
    var response = window.prompt(questions[i].prompt);
    if (response == questions[i].answer) {
        score++;
        alert("Correct!");
    } else {
        alert("WRONG!");
    }
}
alert("you got " + score + "/" + questions.length);