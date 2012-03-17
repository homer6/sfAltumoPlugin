if( !al ) var al = {};
if( !al.app ) al.app = {};

(function($){

    /**
    * ApiDocumentationBrowserWidget representing a GUI for viewing API Documentation JSON data.
    * The API JSON data has to be in a specific format. [Not yet documented]
    * 
    * Dependencies:
    *   - blueprint.css
    * 
    * @class ApiDocumentationBrowserWidget
    * @namespace al.app
    * @constructor
    * @param {Object} options   Collection of object options
    * @param {Element} element  Required parameter referring to a DOM input with type=file element.
    * 
    */
    



    al.app.ApiDocumentationBrowserWidget = function( options, element ){

        //if( (options !== undefined) ){
            this.init( options, element );
        //}
    };
    
    var ApiDocumentationBrowserWidget = al.app.ApiDocumentationBrowserWidget;
    
    
    /**
    * Initializes this object with these options.
    */
    ApiDocumentationBrowserWidget.prototype.init = function( options, element ){

        //default options
        this.options = {

            /**
            * The route that will be used for retrieving the JSON file
            * 
            * Should return a the API JSON documentation
            *   {
            *       image_url: 
            *   }
            *
            * @config
            * @type {integer}
            */
            routeRawImageUpload: 'documentation.json',
        };

        //override the default options with the provided ones
        this.options = $.extend( true, {}, this.options, options );
        
        this.setElement( element );

        this.setupDom();

    };
    
    
    /**
    * Builds initial dom elements.
    * 
    * @method setupDom
    */
    ApiDocumentationBrowserWidget.prototype.setupDom = function(){
    
        try{


            
            // Get Element          
                var element = this.getElement();        
                var $element = $(element);
                var that = this; 
                

            // Apply blueprint css classes to main container
                $element.addClass( 'span-24 container last api_documentation_body' );
                
                
            // Create left column (menu)    
                $left_column = $( '<div class="span-5 container left_column">' );
                    
                $menu = $( '<div class="span-5 container last menu">' );
                    
                $left_column.append( $menu );
                
                
            // Create right column (content)
                $right_column = $( '<div class="span-5 container right_column">' );
                
                    
            $element.append( $left_column );
            $element.append( $right_column );
            
            
            alert('a');
            return;
                
               
        }catch( e ){
            alert(e);
            if( $element ){
                $element.remove();
            }            
            alert( e.message );
        }
    };


    /**
    * Setter for the element field on this SetMyPictureDialog.
    * 
    * @method setElement
    * @param {Element} element
    */
    ApiDocumentationBrowserWidget.prototype.setElement = function( element ){
    
        this._element = element;
        
    };
    
    
    /**
    * Getter for the element field on this SetMyPictureDialog.
    * 
    * @method getElement
    * @return {Element}
    */
    ApiDocumentationBrowserWidget.prototype.getElement = function(){
    
        if( this._element === undefined ){
            this._element = document.createElement('div');
        }        
        return this._element;
        
    };
    
})(jQuery);




//jQuery Pluginify a class
//Classes that are attached to DOM elements ( eg. widgets or models ) need to be added as plugins.

if( al.app.ApiDocumentationBrowserWidget ){
    $.fn.extend({
        'api_documentation_browser': function(options) {
            return this.each(function(){
                $(this).data('api_documentation_browser', new al.app.ApiDocumentationBrowserWidget( options, this ) );
            });
        }
    });
}

