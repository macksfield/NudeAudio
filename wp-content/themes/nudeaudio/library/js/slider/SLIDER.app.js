/**
 * Copyright (C) 2013 by Luke Freeman | jjmarketing.co.uk
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
  
var SLIDER = SLIDER || {}
SLIDER.app = new function() {

		var gallery 		= document.getElementById('slider'),
			base_url 		= 'http://nudeaudio.com/wp-content/themes/nudeaudio/library/js/slider/',
			imageMatrix 	= [],
			colourStart 	= 'white',
			colourNext 		= null,
			colourCurrent 	= colourStart,
			colourTitle 	= 'Choose your colour',
			isAnimating 	= false;

		//Init application ============================================================== /
		this.init = function(){

			//console.log('Slider loaded...');

			if(gallery!=null){

				//build the gallery
				buildGallery(function(img){

					var firstItem = true;

					jQuery(img[0].parentNode).addClass('first-item');

					//hide the images which are not selected
					for(var i=0,max=img.length; i<max; i++){
						if(img[i].className!=colourStart){

							if(firstItem) { jQuery(img[i].parentNode).addClass('first-item'); firstItem=false; }
							img[i].parentNode.style.display = 'none';

						}else{
							//load first image into main view
							gallery.firstChild.innerHTML='<img src="'+img[i].src+'"/>';
						}
					}

				});

			}

		}

		//Functions ===================================================================== /
		function buildGallery(callback){

			//add colour swatches
			swatch1 = document.createElement("li");
			gallery.insertBefore(swatch1,gallery.firstChild);
			gallery.firstChild.setAttribute('class','swatch');
			gallery.firstChild.setAttribute("id", "swatch_1");

			swatch2 = document.createElement("li");
			gallery.insertBefore(swatch2,gallery.firstChild);
			gallery.firstChild.setAttribute('class','swatch');
			gallery.firstChild.setAttribute("id", "swatch_2");

			//add the swatch title
			swatchTitle = document.createElement('li');
			gallery.insertBefore(swatchTitle,gallery.firstChild);
			swatchTitle.setAttribute('class', 'swatch-title');
			e = document.getElementById('swatch_1');
			//e.appendChild(swatchTitle);
			jQuery('.swatch-title').html(colourTitle);

			//add the triangles
			triangle1 = document.createElement('img');
			triangle1.setAttribute('class', 'swatch-triangle activated');
			triangle1.setAttribute('src', base_url+'triangle.png');
			e = document.getElementById('swatch_1');
			e.appendChild(triangle1);

			triangle2 = document.createElement('img');
			triangle2.setAttribute('class', 'swatch-triangle');
			triangle2.setAttribute('src', base_url+'triangle.png');
			e = document.getElementById('swatch_2');
			e.appendChild(triangle2);

			//add hit map
			hitmap = document.createElement('div');
			hitmap.setAttribute('id', 'hitmap-1');
			e = document.getElementById('swatch_1');
			e.appendChild(hitmap);

			//add hit map
			hitmap2 = document.createElement('div');
			hitmap2.setAttribute('id', 'hitmap-2');
			e = document.getElementById('swatch_2');
			e.appendChild(hitmap2);
			
			
			
			//create the view window
			li = document.createElement("li");
			gallery.insertBefore(li,gallery.firstChild);
			gallery.firstChild.setAttribute('class','main-view');

			//get child img elements
			var nodes = gallery.children;
			
			//assign ID's & class
			for(var i=4,max=nodes.length;i<max;i++){
				nodes[i].setAttribute("id", "img_"+i);
				nodes[i].setAttribute("class", "slider_item");
			}

			//get images
			for(var i=4,max=nodes.length;i<max;i++){
				imageMatrix.push(nodes[i].children[0]);

				hoverline = document.createElement("div");
				if(nodes[i].firstChild.className=='white'){
					hoverline.setAttribute('class', 'hover-line bg-green');
				}else{
					hoverline.setAttribute('class', 'hover-line bg-red');
				}
				nodes[i].appendChild(hoverline);
			}
			


			callback(imageMatrix);
		}

		function showItem(e){
		
			// set all slide items to inactive
			jQuery('.slider_item').removeClass('active');
			// set the clicked slide item to active
			jQuery(e).addClass('active');
		
			var img = e.children[0].src;

			jQuery('.main-view img').fadeOut(function(){
				jQuery('.main-view').html('<img src="'+img+'" style="display:none" />');
				jQuery('.main-view img').fadeIn();
			});

		}

		function swapOut(callback){
			isAnimating = true;
			for(var i=0,max=imageMatrix.length; i<max; i++){
				if(imageMatrix[i].className==colourCurrent){
					jQuery(imageMatrix[i].parentNode).fadeOut();	
				}
			}
			// Before fading out the main image get and fix the height of the #slider element so that the height doesn't jump when the main image is not there
			var slider_height = jQuery('#slider').height();
			jQuery('#slider').height(slider_height);
			jQuery('.main-view img').fadeOut(function(){
				swapIn();				
			});
			
			//setTimeout(swapIn,500);
		}

		function swapIn(){
			
			var x;
			for(var i=0,max=imageMatrix.length; i<max; i++){
				if(imageMatrix[i].className!=colourCurrent){
					jQuery(imageMatrix[i].parentNode).delay(1000).fadeIn(1000, function(){
						// Now reset the #slider css height to 'auto' so that it will adjust if the window is resized
						jQuery('#slider').css({ "height": "auto" });		
					});					
					x=i;	
				}
			}

			oldClass = colourCurrent;
			colourCurrent = imageMatrix[x].className;
			jQuery('#slider-background').switchClass("bg-"+oldClass, "bg-"+colourCurrent);

			setTimeout(function(){
									jQuery('.main-view').html('<img src="'+imageMatrix[x].src+'" style="display:none" />');
									jQuery('.main-view img').fadeIn();
									jQuery('#slider').removeClass('bg-'+colourCurrent);									
								},500);

			
			jQuery('.swatch-title').switchClass("swatch-title-"+colourCurrent, "swatch-title-"+oldClass, 500, "easeInOutQuad");
			isAnimating = false;			
			
		}

		//Document / Window events ====================================================== /
		jQuery(window).load(function(){
	
			jQuery('.swatch').click(function(){
				if(!isAnimating) swapOut();				
			}); 

			jQuery('#swatch_1, #swatch_2').mouseover(function(){
				jQuery('.swatch-triangle',this).stop().fadeIn(200);
			});

			jQuery('#swatch_1, #swatch_2').mouseout(function(){
				jQuery('.swatch-triangle',this).fadeOut(200);
			}); 

			jQuery('#swatch_1').click(function(){
				jQuery('.swatch-triangle',this).addClass('activated');
				jQuery('#swatch_2 .swatch-triangle').removeClass('activated');
			});

			jQuery('#swatch_2').click(function(){
				jQuery('.swatch-triangle',this).addClass('activated');
				jQuery('#swatch_1 .swatch-triangle').removeClass('activated');
			});

			jQuery('.slider_item').click(function(){
				showItem(this);
				jQuery('.hover-line').removeClass('activated');
				jQuery('.hover-line',this).addClass('activated');
			});

			jQuery('.slider_item').mouseover(function(){
				jQuery('.hover-line', this).fadeIn();
			})

			jQuery('.slider_item').mouseout(function(){
				jQuery('.hover-line', this).fadeOut();
			})
		});

		//Utilities ===================================================================== /
		
		//Json object http caller
		function Json(){
			this.url = '';
			this.get = function(callback)
			{
				jQuery.getJSON(this.url+'&callback=?', function(data) {
				   callback(data);
				}); 
			}
		}

		//Random number generator
		function rand(min, max){
    		return Math.random() * (max - min) + min;
		} 

		
}