var numQuestions = 1;
var numAns = [1];

function addQuestion(){
	numQuestions++;
	numAns.push(1);
	$('#questions').append(`<div id='d${numQuestions}'>${numQuestions}.) <input id='q${numQuestions}' name='q${numQuestions}'><button type="button" onclick="removeQuestion(${numQuestions});">X</button><div id="q${numQuestions}a"><input type="radio" id="q${numQuestions}a1r" name="q${numQuestions}r" value="q${numQuestions}a1i"><label for="q${numQuestions}a1r"><input type='text' id='q${numQuestions}a1i' name='q${numQuestions}a1i'></label><br></div><br><button type="button" onclick="addAnswer(${numQuestions});">Add Answer</button></div><br id="br${numQuestions}">`);
}

function addAnswer(qNum){
	numAns[qNum-1]++;
	$('#q' + qNum + 'a').append(`<input type="radio" id="q${qNum}a${numAns[qNum-1]}r" name="q${qNum}r" value="q${qNum}a${numAns[qNum-1]}i"><label for="q${qNum}a${numAns[qNum-1]}r"><input type='text' id='q${qNum}a${numAns[qNum-1]}i' name='q${qNum}a${numAns[qNum-1]}i'></label><br>`);
}

function removeQuestion(qNum){
	$('#d' + qNum).remove();
	$('#br' + qNum).remove();
}