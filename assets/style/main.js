(function() {
	
	function Slideshow( element ) {
		this.el = document.querySelector( element );
		this.init();
	}
	
	Slideshow.prototype = {
		init: function() {
			this.wrapper = this.el.querySelector( ".slider-wrapper" );
			this.slides = this.el.querySelectorAll( ".slide" );
			this.previous = this.el.querySelector( ".slider-previous" );
			this.next = this.el.querySelector( ".slider-next" );
			this.index = 0;
			this.total = this.slides.length;
			this.timer = null;
			
			this.action();
			this.stopStart();	
		},
		_slideTo: function( slide ) {
			var currentSlide = this.slides[slide];
			currentSlide.style.opacity = 1;
			
			for( var i = 0; i < this.slides.length; i++ ) {
				var slide = this.slides[i];
				if( slide !== currentSlide ) {
					slide.style.opacity = 0;
				}
			}
		},
		action: function() {
			var self = this;
			self.timer = setInterval(function() {
				self.index++;
				if( self.index == self.slides.length ) {
					self.index = 0;
				}
				self._slideTo( self.index );
				
			}, 7000);
		}
		
		
	};
	
	document.addEventListener( "DOMContentLoaded", function() {
		
		var slider = new Slideshow( "#main-slider" );
		
	});

	
})();
















// for form validation
var unsupportedBrowsers = false;
if ((navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) || (navigator.userAgent.match(/MSIE\s(?!10)/))) {
  unsupportedBrowsers = true;
}

// Tests with Modernizr if supports HTML5 placeholder="" attribute. If old browser, load necessary JS files and run them
if (!Modernizr.input.placeholder) {
  Modernizr.load({
    load: [
      'http://lab.alexcican.com/minimal_signup_form/placeholder.min.js',
    ],
    complete: function(){
      $('input').placeholder();
    }
  });
}

// ugly browser sniffer for form validation
if (unsupportedBrowsers) {
  Modernizr.load({
    load: [
      'http://lab.alexcican.com/minimal_signup_form/jquery.validate.min.js'
    ],
    complete: function(){
      // parse through each required input
      $('form').find('input[required]').each(function () {
        // add a class to each required field with "required" & the input type
        // using the normal "getAttribute" method because jQuery's attr always returns "text"
        $(this).attr('class', 'required ' + this.getAttribute('type')).removeAttr('required');
      });

      // call jQuery validate plugin on each form
      $('form').each(function () {
        $(this).validate();
      });
    }
  });
}

// check password strength on key up
$('#password').keyup(function() {
  var pass = $(this).val();
  var cacheResult = checkPassStrength(pass);
});

// rates user's password
function scorePassword(pass) {
  var i = pass.length,
      score = 0;
  if (i >= 7) {
    score += /[a-z]/.test(pass) ? 3 : 0;
    score += /[A-Z]/.test(pass) ? 4 : 0;
    score += /\d/.test(pass) ? 1 : 0;
    score += /[^\w\d\s]/.test(pass) ? 1 : 0;
  }
  if (i >= 22 && score >= 9)
    score += 1;

  return score;
}

// adds classes depending on score
function checkPassStrength(pass) {
  var score = scorePassword(pass);
  console.log(score);
  if (score < 1)
    $('#password, #passwordMeter').removeClass().addClass('weak');
  if (score >= 7)
    $('#password, #passwordMeter').removeClass().addClass('good');
  if (score >= 8)
    $('#password, #passwordMeter').removeClass().addClass('better');
  if (score >= 9)
    $('#password, #passwordMeter').removeClass().addClass('strong');
  if (score >= 10)
    $('#password, #passwordMeter').removeClass().addClass('military');
}




