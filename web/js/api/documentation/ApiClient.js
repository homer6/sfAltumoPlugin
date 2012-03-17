/**
 * @class ApiClient.ClientWindow
 * @extends Ext.window.Window
 *
 * Shows a GUI based REST Api Client.
 * 
 * @constructor
 * Create a new ApiClient
 * @param {Object} config The config object
 */

Ext.define('ApiClient.ClientWindow', {
    extend: 'Ext.window.Window',
    
    alias: 'apiclient.clientwindow',
    
    initComponent: function(){
        Ext.apply(this, {
            title: 'REST API Client',
            height: 700,
            width: 730,
            layout: 'fit',
            items: [ this.createMainPanel() ]
        }, {
            default_authorization_header: 'Basic '
        });

        this.callParent(arguments);
    },
    
    /**
     * Create the main panel
     * @private
     * @return {Ext.panel.Panel}
     */
    createMainPanel: function(){
        
        this.requestFields = {};
        this.responseFields = {};
        
        this.mainPanel = Ext.create('Ext.panel.Panel', {
            bodyPadding: 5,  // Don't want content to crunch against the borders
            title: 'Filters',
            items: [
                this.requestFields.route = Ext.create( 'Ext.form.TextField', {
                    xtype: 'textfield',
                    fieldLabel: 'Route',
                    width: 400
                }), 
                this.requestFields.method = Ext.create( 'Ext.form.TextField',{
                    xtype: 'textfield',
                    fieldLabel: 'Method',
                    value: 'GET',
                    width: 150
                }),
                this.requestFields.headers = Ext.create( 'Ext.form.TextField',{
                    xtype: 'textfield',
                    width: 700,
                    fieldLabel: 'Request Headers',
                    value: '{ "Authorization": "' + this.default_authorization_header + '", "X-API-Version":"1.0", "Accept": "application/json" }'
                }),
                this.requestFields.parameters = Ext.create( 'Ext.form.TextField',{
                    xtype: 'textfield',
                    width: 700,
                    fieldLabel: 'Request Params',
                    value: '{ "page":1, "page_size":100 }'
                }),
                this.requestFields.body = Ext.create( 'Ext.form.TextArea',{
                    xtype: 'textarea',
                    width: 700,
                    height: 140,
                    fieldLabel: 'Request Body',
                    value: '{\n}'
                }),                
                this.responseFields.body = Ext.create( 'Ext.form.TextArea',{
                    xtype: 'textarea',
                    width: 700,
                    height: 350,
                    fieldLabel: 'Response',
                    value: '...'
                })
            ],
            buttons: [
                {
                    text: "Submit",
                    listeners: {
                        click: {
                            fn: this.submitRequest,
                            scope: this
                        }    
                    }
                }
            ]
        });
        
        return this.mainPanel;
    },
    
    /**
    * Set the value of the route request field.
    * @public
    * @param value string
    * @return void
    */
    setRequestRouteValue: function( value ){
        
        this.requestFields.route.setValue( value );
        
    },    
    
    /**
    * Set the value of the method request field.
    * @public
    * @param value string
    * @return void
    */
    setRequestMethodValue: function( value ){
        
        this.requestFields.method.setValue( value );
        
    },
        
    /**
    * Set the value of the parameters request field.
    * @public
    * @param value string
    * @return void
    */
    setRequestParametersValue: function( value ){
        
        this.requestFields.parameters.setValue( value );
        
    },
    
    /**
    * Submits a new API request using Ajax.
    * @private
    * @return void
    */
    submitRequest: function(){
        var route = this.requestFields.route.getValue();
        var method = this.requestFields.method.getValue();
        
        if( !route.length ){
            alert( 'Please type in a route' );
            return;
        }
        
        try {
            var headers = JSON.parse( this.requestFields.headers.getValue() );
        } catch( e ){
            alert( 'there is an error in your headers JSON' );
            return;
        }
        
        try {
            var parameters = JSON.parse( this.requestFields.parameters.getValue() );
        } catch( e ){
            alert( 'there is an error in your parameters JSON' );
            return;
        }
        
        
        var body = {};
        var body_content = this.requestFields.body.getValue();
        
        try {
            body = JSON.parse( body_content );
        } catch(e) {
            body = body_content;
        }

        Ext.Ajax.disableCaching = false;
        
        this.responseFields.body.setValue( 'waiting....' ); 
        
        var processResponse = function( response ){
            
            try {
                var response_body_object = JSON.parse( response.responseText );
                
                var response_body_string = JSON.stringify( response_body_object, null, ' ' );
            } catch(e) {
                response_body_string = response.responseText;
            }

            var response_headers =  "----\nStatus: " + response.status + "(" + response.statusText + ")\n";
            response_headers = response_headers + "Headers: " + JSON.stringify(  response.getAllResponseHeaders() , null, ' ') + " \n----";

            this.responseFields.body.setValue( response_headers + "\n\n" + response_body_string ); 
        };
        
        Ext.Ajax.request({
            "url": route,

            "method": method,
            
            "params":  parameters,

            "headers": headers,
            
            "jsonData": body,

            success: processResponse,
            
            failure: processResponse,
            
            scope: this
        });
    },
    
    // Inherit docs
    onDestroy: function(){
        this.callParent(arguments);
        //this.menu.destroy();
    }
});
