function Mathematics(el, options) {
	this.el = el;
	this.options = options;
	this.question = {};
	this.questionsTemplates = {};
	this.init();
}

Mathematics.prototype.init = function() {
	this.questionsTemplates = this.getTemplates();
	this.getQuestion();
}

Mathematics.prototype.getQuestion = function() {
	var _this = this;
	$.ajax({
		method: 'GET',
		url: '/webroot/mathematics.php',
		data: { category: this.options.category },
		dataType: 'json',
		success: function(data) {
			_this.question = data;
			if(data.success) {
				_this.generateQuestion();
				_this.bindKeyboardEvents();
				_this.bindAnswerSubmitEvent();
			}
		},
		error: function(error) {
			console.log('error');
		}
	});
}

Mathematics.prototype.generateQuestion = function() {
	switch(this.options.category) {
		case 1:
			this.el.html(this.questionsTemplates.firstQuestion
							.replace('{expression}', this.question.expression)
						);
			break;
		case 2:
			this.el.html(this.questionsTemplates.secondQuestion
							.replace('{expression}', this.question.leftSide.expression)
							.replace('{rightSide}', this.question.rightSide)
						);
			break;
		case 3:
			this.el.html(this.questionsTemplates.thirdQuestion
							.replace('{expression1}', this.question.leftSide.expression)
							.replace('{expression2}', this.question.rightSide.expression)
						);
			break;
		default:
			break;
	}
}

Mathematics.prototype.getTemplates = function() {
	return {
		firstQuestion: [
			'<div class="question-structure mathematics-background">',
				'<h3 class="text-center">Израчунај резултат</h3>',
				'<div class="text-center">',
					'<div class="expression">{expression} = </div>',
					'<div class="answer">?</div>',
					'<button class="btn btn-success btn-answer">Реши</button>',
				'</div>',
			'</div>'
		].join(''),
		secondQuestion: [
			'<div class="question-structure mathematics-background">',
				'<h3 class="text-center">Упореди леву и десну страну</h3>',
				'<div class="text-center">',
					'<div class="expression">{expression} </div>',
					'<div class="answer">?</div> ',
					'<div class="expression">{rightSide}</div>',
					'<button class="btn btn-success">Реши</button>',
				'</div>',
			'</div>'
		].join(''),
		thirdQuestion: [
			'<div class="question-structure mathematics-background">',
				'<h3 class="text-center">Упореди леву и десну страну</h3>',
				'<div class="text-center">',
					'<div class="expression">{expression1} </div>',
					'<div class="answer">?</div>',
					'<div class="expression">{expression2} </div>',
					'<button class="btn btn-success btn-answer">Реши</button>',
				'</div>',
			'</div>'
		].join('')
	};
}

Mathematics.prototype.nextQuestion = function() {
	this.goForCandy();
	switch(this.options.category) {
		case 1:
			this.options.category++;
			this.startSecondQuestionTimer();
			break;
		case 2:
			this.options.category++;
			if(this.options.secondQuestionTimerStarted) {
				this.stopSecondQuestionTimer();
			}
			break;
		case 3:
			this.options.category = 1;
			this.startCandyPauseTimer();
			break;
		default:
			this.options.category = 1;
			break;
	}
	this.question = {};
	this.getQuestion();
}

Mathematics.prototype.goBack = function() {
	if(this.options.secondQuestionTimerStarted) {
		this.stopSecondQuestionTimer();
	}
	this.options.category = 1;
	this.question = {};
	this.getQuestion();
}

Mathematics.prototype.startSecondQuestionTimer = function() {
	console.log('start second question timer');
	var _this = this,
		seconds = 0;

	this.options.secondQuestionTimerStarted = true;
	this.timer = setInterval(function() {
		if(++seconds === _this.options.secondQuestionTimerTime) {
			_this.goBack();
		}
	}, 1000);
}

Mathematics.prototype.startCandyPauseTimer = function() {
	console.log('start candy pause timer');
	var _this = this,
		seconds = 0;

	this.options.candyPauseTimerStarted = true;
	this.pauseTimer = setInterval(function() {
		if(seconds++ === _this.options.candyPauseTimerTime) {
			_this.stopCandyPauseTimer();
		}
	}, 1000);
}

Mathematics.prototype.stopSecondQuestionTimer = function() {
	console.log('stop second question timer');
	clearInterval(this.timer);
	this.options.secondQuestionTimerStarted = false;
}

Mathematics.prototype.stopCandyPauseTimer = function() {
	console.log('stop candy pause timer');
	clearInterval(this.pauseTimer);
	this.options.candyPauseTimerStarted = false;
}

Mathematics.prototype.goForCandy = function() {
	if(!this.options.candyPauseTimerStarted) {
		console.log('izbaci candy');
		$.ajax({
			method: 'POST',
			url: '/webroot/giveCandy.php',
			data: { giveCandy: true },
			dataType: 'json',
			success: function(data) {
				console.log('success give candy');
			},
			error: function(error) {
				console.log('error give candy');
			}
		})
	}
	else {
		console.log('nema candy');
	}
}

Mathematics.prototype.bindKeyboardEvents = function() {
	var _this = this;
	$('.keyboard-list').off().on('click', 'span', function() {
		var clickedKey = $(this).data('key');
		$(_this.el).find('.answer').html(clickedKey).data('key', clickedKey);
	});
}

Mathematics.prototype.bindAnswerSubmitEvent = function() {
	var _this = this;
	$(this.el).find('button').off().on('click', function() {
		var userAnswer = $(_this.el).find('.answer').data('key');
		if(userAnswer === _this.question.result) {
			_this.nextQuestion();
		}
		else {
			_this.goBack();
		}
	});
}


var el = $('#content'),
	options = {
		category: 1,
		secondQuestionTimerTime: 180,
		candyPauseTimerTime: 900
	};

var mathematics = new Mathematics(el, options);