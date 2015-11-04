/*
 * Projekktor II Plugin: Title
 * DESC: Provides a fancy title/html overlay hooked to player and mousover -states
 *
 * under GNU General Public License
 * http://www.projekktor.com/license/
 */
var projekktorPostertitle = function(){};
jQuery(function($) {
projekktorPostertitle.prototype = {

	version: '2.0.1',
	reqVer: '1.3.00',    
    tc: {},
	_timer: null,
	_lastState: null,
	config: {
		html: false,
		autoHide: 7,
		showOnMouseover: false,
		showOnIdle: true,
		showOnStarting: true,
		showOnPaused: true
	},

        
    /*****************************************
     * INIT
     ****************************************/    
    initialize: function() {        
        this.tc = this.applyToPlayer($('<div/>'));		
        $p.utils.blockSelection(this.tc);        
		this.pluginReady = true;
    },
    
    
    /*****************************************
     * EVENT HANDLERS
     ****************************************/
    itemHandler: function() {
        this.tc.html(this.getConfig('html') || this.getConfig('title'));
    },
    
    stateHandler: function(state) {	
		if (this.getConfig("showOn" + $p.utils.capitalise(state))===true) {
			this.showTitle();
		} else {
			this.hideTitle();
		}
    },
    
    mouseleaveHandler: function(obj) {
		if (!this.pp.getState('IDLE') && !this.pp.getState('PAUSED') && this.getConfig('autoHide')===false) {
			this.hideTitle();
		}
    },
    
    mouseenterHandler: function(obj) {
		if (this.getConfig('showOnMouseover')===true) {
			this.showTitle();
		}
    },
	
	showTitle: function() {
		var ref = this;
		
		clearTimeout(this._timer);

		if (this.tc.html()==='') {
			this.setInactive();
			return;
		}
		
		this.setActive();
		
		this._timer = null;
		if (this.getConfig('autoHide')!==false && !this.pp.getState('IDLE') && !this.pp.getState('PAUSED') ) {
			this._timer = setTimeout(function () {ref._timer=null; ref.hideTitle();}, this.getConfig('autoHide')*1000);
		}

	},
	
	hideTitle: function() {
		if (this._timer===null)
			this.setInactive();
	}	

};
});
