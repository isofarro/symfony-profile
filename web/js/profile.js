if (typeof ISOLANI == "undefined" || !ISOLANI) {
    var ISOLANI = {};
}

ISOLANI.Gallery = function() {
	// Shortcuts to YUI
	var yDom   = YAHOO.util.Dom;
	var yEvent = YAHOO.util.Event;
	
	/**
	* Initialises the gallery contained in the module pattern element.
	*
	* @param modEl - the id or the DOM element that is the .mod wrapper
	**/
	function initGallery(modEl) {
		var body = yDom.getElementsByClassName('bd', null, modEl)[0];
		createWidgets(body);
	}
	
	/**
	* Moves the carousel one item forward - or to the start of the list
	* if it's already at the end
	*
	* @param e - the Event
	* @param state = the state object
	**/
	function nextSlide(e, state) {
		//console.log(state);
		
		state.offset++;
		if (state.offset>state.max) {
			state.offset = 0;
		}
		
		var relPos = state.offset * state.width;
		setRelativePosition(state.listId, relPos);		
	}
	
	/**
	* Moves the carousel one item back - or to the end of the list
	* if it's already at the start
	*
	* @param e - the Event
	* @param state = the state object
	**/
	function previousSlide(e, state) {
		//console.log(state);

		state.offset--;
		if (state.offset<0) {
			state.offset = state.max;
		}
		
		var relPos = state.offset * state.width;
		setRelativePosition(state.listId, relPos);		
	}
	
	/**
	* Sets the relative position of the list of images
	* This updates the stylerules to move the carousel
	*
	* @param listId - the id or DOM element of the list
	* @param relPos - the Relative position to offset by (in pixels)
	**/
	function setRelativePosition(listId, relPos) {
		//console.log(listId + ': ' + relPos);
		var el = yDom.get(listId);
		if (el) {
			//yDom.setStyle(el, 'left', '-' + relPos + 'px');
			var anim = new YAHOO.util.Anim(
				listId,
				{
					left: { to: -relPos }
				},
				0.5,
				YAHOO.util.Easing.easeOut
			);
			anim.animate();
		}
	}
	
	/**
	* Creates the necessary markup for the carousel, including:
	* * Internal wrappers
	* * Buttons
	* * Fieldset and legends to group the buttons (accessibility aids)
	*
	* Also adds in the event handlers for the buttons
	*
	* @param body a reference to the outer container of the gallery
	**/
	function createWidgets(body) {

		var state = {
			offset:  0,
			width:   0,  // Calculated
			total:   0,  // Calculated
			max:     0,  // Calculated
			perpage: 0,  // Calculated
			listId:  ''  // Calculated
		};
		
		// DOM nodes
		var 	fieldset    = document.createElement('fieldset'), 
				legend      = document.createElement('legend'), 
				previousBtn = document.createElement('button'), 
				nextBtn     = document.createElement('button'),
				inner       = document.createElement('div');
		
		// local variables
		var el, listItems, region, innerWidth;
		
		fieldset.className = 'bd';
		inner.className    = 'inner';
		legend.appendChild(document.createTextNode('Photo Gallery'));
		previousBtn.appendChild(document.createTextNode('<'));		
		nextBtn.appendChild(document.createTextNode('>'));
		yEvent.on(previousBtn, 'click', previousSlide, state);
		yEvent.on(nextBtn, 'click', nextSlide, state);
		
		fieldset.appendChild(legend);
		fieldset.appendChild(previousBtn);
		fieldset.appendChild(inner);
		fieldset.appendChild(nextBtn);
		
		// TODO: Find a way of moving all the child elements faster
		while(body.childNodes.length) {
			el = body.childNodes[0];
			
			// Get the id of the photo list
			if (el.nodeType==1 && (el.nodeName=='OL' || el.nodeName=='UL')) {
				if (!el.id) {
					yDom.generateId(el);
				}
				state.listId = el.id;
			}
			
			// By adding the child to a different node
			// it reduces the number of children by one
			inner.appendChild(body.childNodes[0]);
		}

		// Remove body from the document
		body.parentNode.replaceChild(fieldset, body);

			

		// Calculate the total number of images
		// and the width of those images
		// Assumes all the images are the same width
		listItems     = inner.getElementsByTagName('LI');
		region        = yDom.getRegion(listItems[0]);
		state.total   = listItems.length;
		state.width   = region.right - region.left;
		//state.width   = 95;

		// Calculate the number of images per page
		// and the maximum number of offsets allowed
		region        = yDom.getRegion(inner);
		innerWidth    = region.right - region.left;
		state.perpage = innerWidth / state.width;
		state.max     = state.total - state.perpage;

		//console.log(state);
		
		// Clear all DOM references
		fieldset = legend = previousBtn = nextBtn = inner = 0;		
	}
	
	var pub = {
		init: function(gallery) {
			console.log('Init');
			var el = yDom.get(gallery);
			if (el) {
				initGallery(el);
			}
		}
	}
	return pub;

}();


YAHOO.util.Event.on(window, 'load', function() {
	ISOLANI.Gallery.init('myPhotos');
});
