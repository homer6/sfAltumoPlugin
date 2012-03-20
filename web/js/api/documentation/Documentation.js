/**
 * @class Documentation.Documentation
 * @extends Ext.container.Viewport
 *
 * The main Documentation application
 * 
 * @constructor
 * Create a new Documentation app
 * @param {Object} config The config object
 */

Ext.define('Documentation.App', {
    extend: 'Ext.container.Viewport',
    
    requires: [
        'Ext.panel.*',
        'Ext.util.ClickRepeater',
        'Ext.layout.component.Button',
        'Ext.util.TextMetrics',
        'Ext.util.KeyMap'
    ],
    
    /**
    * Initialize the Component
    */
    initComponent: function(){

        Ext.apply(this, {
            layout: 'border',
            padding: 2,
            items: [this.createMenuPanel(), this.createContentPanel()]
        });
        
        this.callParent(arguments);
            
        // Load documentation json from route.
            Ext.Ajax.request({
                url: this.documentation_data_route,
                params: {
                    id: 1
                },
                success: function(response){
                    
                    try {
                        var response_object = Ext.decode(response.responseText);
                    } catch( e ){
                        alert( 'Invalid JSON API data' );
                        if( console && console.debug ){
                            console.debug( [e, response.responseText] );
                        }
                        return;
                    }
                    
                    // Compile data templates and pre-process data.
                        this.compileDocumentationData( response_object );

                    // Load documentation data (triggers menu rendering)
                        this.loadDocumentationData( response_object );
                        
                    // Store data object
                        this.setDocumentationDataObject( response_object );
                        
                    // Render homepage
                        this.renderHomePage();
                },
                scope: this
            });
    },
    
    
    /**
    * Load the documentation data and store it.
    * 
    * 
    * @private
    * @return void
    */
    loadDocumentationData: function( received_data_object ){
        
        var object_keys = [];
        var event_keys = [];
        
        
        
        // Add All objects to menu in alphabetical order.
            Ext.iterate( received_data_object.objects, function( key, object, all_objects ){
                object_keys.push( key );
            }, this);
            
            object_keys.sort();
            
            Ext.each( object_keys, function( object_key ){
                this.addDocumentationObject( object_key, received_data_object.objects[object_key], received_data_object );
            }, this);
            
        
        // Add All Events to the menu in alphabetical order
            Ext.iterate( received_data_object.events, function( key, event, all_events ){
                event_keys.push( key );
            }, this);
            
            object_keys.sort();
            
            Ext.each( event_keys, function( event_key ){
                this.addDocumentationEvent( event_key, received_data_object.events[event_key], received_data_object );
            }, this);
            

        //this.menuPanel.html 
    },

    
    /**
    * Parses the documentation object to allow for usage of data templates (in the JSON structure)
    * 
    * It will replace the "templates" block within documentation_data with the processed version.
    * It will also modify the structure of each method to "inherit" from the templates.
    * 
    * @private
    * @return void
    */
    compileDocumentationData: function( documentation_data ){
        
        var templates = documentation_data.templates;
        
        var processed = {
            "request": {
                "base": {
                    "headers": {},
                    "parameters": {},
                    "body_parts": {}
                },
                "methods": {
                    "GET": {
                        "headers": {},
                        "parameters": {},
                        "body_parts": {}
                    },                
                    "POST": {
                        "headers": {},
                        "parameters": {},
                        "body_parts": {}
                    },                
                    "PUT": {
                        "headers": {},
                        "parameters": {},
                        "body_parts": {}
                    },                
                    "DELETE": {
                        "headers": {},
                        "parameters": {},
                        "body_parts": {}
                    }
                }
            },
            "response": {
                "base": {
                    "headers": {},
                    "parameters": {},
                        "body_parts": {}
                },
                "methods": {
                    "GET": {
                        "headers": {},
                        "parameters": {},
                        "body_parts": {}
                    },                
                    "POST": {
                        "headers": {},
                        "parameters": {},
                        "body_parts": {}
                    },                
                    "PUT": {
                        "headers": {},
                        "parameters": {},
                        "body_parts": {}
                    },                
                    "DELETE": {
                        "headers": {},
                        "parameters": {},
                        "body_parts": {}
                    }
                }
            }
        };
        
        /**
        * The "templates" block in the JSON structure contains a "base" block of objects,
        * and a "methods" block. These are common sets of headers or parameters that object methods
        * can augment or use as is.
        * 
        * indexTemplateBlock indexes and mixes each of the "method" objects with the matching "base"
        * objects so that they are ready to be used for documentation object methods.
        */
        var indexTemplateBlock = function ( raw_block, extend_from_block ){

            
            var processed_block = {};
            
            // If extending from a block, copy all properties of the parent block first.
                if( typeof( extend_from_block ) == 'object'  ){
                    processed_block = Ext.clone( extend_from_block );
                } else {
                    extend_from_block = {};
                }
            
            Ext.each( raw_block, function( object, object_index ){
                
                // An "index" attribute called "name" is required.
                    if( !object.name ){
                        throw new Exception( "Template object must have a name attribute. \n\n" + JSON.stringify( object ) );
                    }

                // Initialize "processed" structure for this object, whithin the target "processed_block"
                    if( !processed_block[object.name] ){
                        processed_block[object.name] = {};
                    }
                
                // If extending from a block, try to find the object by index.
                    if( extend_from_block[object.name] ){
                        extend_from_object = Ext.clone( extend_from_block[object.name] );
                    } else {
                        extend_from_object = {};
                    }
 
                // Then apply object using defaults from "parent"
                    Ext.apply( processed_block[object.name], object, extend_from_object );
            });
            

            
            return processed_block;
        };
        
        // Process both the request and response data blocks
            Ext.each( [ 'request', 'response' ], function( block ){
                // Process templates base structure first
                    processed[block].base.headers      = indexTemplateBlock( templates[block].base.headers, {} );
                    processed[block].base.parameters   = indexTemplateBlock( templates[block].base.parameters, {} );   
                    processed[block].base.body_parts   = indexTemplateBlock( templates[block].base.body_parts, {} );   
                        
                // Process each template method
                    Ext.iterate( templates[block].methods, function( method_name, method_object ){
                        processed[block].methods[method_name].headers = indexTemplateBlock( method_object.headers, processed[block].base.headers );
                        processed[block].methods[method_name].parameters = indexTemplateBlock( method_object.parameters, processed[block].base.parameters );
                        processed[block].methods[method_name].body_parts = indexTemplateBlock( method_object.body_parts, processed[block].base.body_parts );
                    }); 
            });

        
        // Replace in templates
            documentation_data.templates = processed;

            
        // Process actual documentation object methods to augment the templates
            Ext.each( [ 'request', 'response' ], function( block ){
                
                // For each object
                    Ext.iterate( documentation_data.objects, function( documentation_data_object_name, documentation_data_object ){
                        

                        
                        // For each method, process all headers, parameters and body_parts
                        Ext.each( documentation_data_object.methods, function( documentation_data_object_method, index ){

                            var http_method = documentation_data_object_method.http_method;

                            var processed_method_headers    = indexTemplateBlock( documentation_data_object_method[block].headers, processed[block].methods[http_method].headers );
                            var processed_method_parameters = indexTemplateBlock( documentation_data_object_method[block].parameters, processed[block].methods[http_method].parameters );
                            var processed_method_body_parts = indexTemplateBlock( documentation_data_object_method[block].body_parts, processed[block].methods[http_method].body_parts );
                            
                            // Used for sorting arrays of documentation blocks by "name"
                                var sortRawBlock = function( a, b ){
                                    if( a.name < b.name ) return -1;
                                    if( a.name > b.name ) return 1;
                                    return 0;
                                }
                                
                            // Now replace the arrays on the documentation data with the processed versions
                                var processed_array_headers = [];
                                var processed_array_parameters = [];
                                var processed_array_body_parts = [];
                                
                                Ext.iterate( processed_method_headers, function( key, processed_object ){
                                    processed_array_headers.push( processed_object );
                                });      
                                processed_array_headers.sort( sortRawBlock );
                                documentation_data_object.methods[index][block].headers =  processed_array_headers;                 

                                Ext.iterate( processed_method_parameters, function( key, processed_object ){
                                    processed_array_parameters.push( processed_object );
                                });
                                processed_array_parameters.sort( sortRawBlock );
                                documentation_data_object.methods[index][block].parameters =  processed_array_parameters;
                                
                                Ext.iterate( processed_method_body_parts, function( key, processed_object ){
                                    processed_array_body_parts.push( processed_object );
                                });
                                processed_array_body_parts.sort( sortRawBlock );
                                documentation_data_object.methods[index][block].body_parts =  processed_array_body_parts;  
                        });
                        
                    });
            });
            
            
            

    },
    
    
    /**
    * Processes a single Object from the documentation JSON and invokes the addition of all of its methods.
    * Adds the object to the menu.
    * 
    * @private
    * @return void
    */
    addDocumentationObject: function( name, object, documentation_data ){

        var object_node = { 
            "text": object.name, 
            "documentation_data": {}, 
            "method": {}, 
            "object": {}, 
            "icon": "/sfAltumoPlugin/images/silk/brick.png"
        };
        

        object_node = this.menuPanel.getObjectsNode().appendChild( object_node );
        
        
        // Add Methods
            Ext.each( object.methods, function( method, index, all_methods ){

                this.addDocumentationMethod(  method, object, documentation_data, object_node );
                //this.addDocumentationMethod(  method, object, documentation_data, menu_section_panel );
                
            }, this);
            
        // Add to menu panel
           // this.menuPanel.add( menu_section_panel );

    },    
    
    /**
    * Processes a single Method from the documentation JSON and adds it to the menu 
    * 
    * @private
    * @return void
    */
    addDocumentationMethod: function( method, object, documentation_data, object_node ){
        
        var icon = '/sfAltumoPlugin/images/silk/cog.png';
        
        switch( method.http_method ){
            case "GET":
                icon = '/sfAltumoPlugin/images/silk/script.png';
            break;            
            
            case "PUT":
                icon = '/sfAltumoPlugin/images/silk/script_edit.png';
            break;
            
            case "POST":
                icon = '/sfAltumoPlugin/images/silk/script_add.png';
            break;
            
            case "DELETE":
                icon = '/sfAltumoPlugin/images/silk/script_delete.png';
            break;
        }
        
        var method_node = { 
            "text": method.http_method, 
            "documentation_data": documentation_data, 
            "method": method, 
            "object": object, 
            "leaf": true,
            "icon": icon
        };
        
        object_node.appendChild( method_node );
    },
    
    /**
    * Renders a method's documentation onto the Content panel.
    * 
    * @param Object method              //Pointer to documentation_data > object > method
    * @param Object object              //Pointer to documentation_data > object
    * @param Object documentation_data
    */
    renderMethodContent: function ( method, object, documentation_data ){

        var content = '';
        
        var renderObject = function( object ){
            
            if( typeof( object ) == 'undefined' ){
                return '';
            }
            
            if( typeof( object ) == 'string' ||  typeof( object ) == 'number'){
                return object;
            }
            
            return '<code><pre>' + JSON.stringify( object, null, ' ') + "</pre></code>";
        };
        
        
        // Heading
            var heading_content = new Ext.XTemplate(
            
                '<h1>Usage of {object.name}</h1>',
                    
                    '<div class="content_block">',
                    '<h2>Definition</h2>',
                        '<div class="text_block">',
                            '<p>{object.definition}</p>',
                        '</div>',
                    '</div>',
                    
                '<h1>Method: {method.http_method}</h1>',
                    
                    '<div class="content_block">',
                        '<h2>Route:</h2>',
                        '<div class="text_block">',
                            '<div class="code">{method.route}</div>',
                        '</div>',

                        '<h2>Description</h2>',
                        '<div class="text_block">',
                            '<p>{method.description}</p>',
                        '</div>',
                    '</div>',
                    
                    { renderObject: renderObject }
            );

            content += heading_content.apply( { "object": object, "method": method, "documentation_data": documentation_data } );
            
            
            
        // Requests
            var request_content = new Ext.XTemplate(
                '<h1>Request</h1>',
                '<div class="content_block request">',

                        '<h2>Headers:</h2>',
                        '<table>',
                            '<thead>',
                                '<th>Header Name</th>',
                                '<th>Description</th>',
                                '<th>Type</th>',
                                '<th>Required</th>',
                                '<th>Possible Values</th>',
                                '<th>Example</th>',
                            '</thead>',
                            '<tpl for="method.request.headers">',
                                '<tr>',
                                    '<td>{name}</td>',
                                    '<td>{description}</td>',
                                    '<td>{type}</td>',
                                    '<td>{required}</td>',
                                    '<td>',
                                        '<tpl for="possible_values">',
                                            '<div>{.}</div>',
                                        '</tpl>',
                                    '</td>',
                                    '<td>{[this.renderObject(values.example)]}</td>',
                                '</tr>',
                            '</tpl>',
                        '</table>',
                    
                    
                    
                        '<h2>Parameters:</h2>',
                        '<table>',
                            '<thead>',
                                '<th>Parameter Name</th>',
                                '<th>Description</th>',
                                '<th>Type</th>',
                                '<th>Required</th>',
                                '<th>Possible Values</th>',
                                '<th>Example</th>',
                            '</thead>',
                            '<tpl for="method.request.parameters">',
                                '<tr>',
                                    '<td>{name}</td>',
                                    '<td>{description}</td>',
                                    '<td>{type}</td>',
                                    '<td>{required}</td>',
                                    '<td>',
                                        '<tpl for="possible_values">',
                                            '<div>{.}</div>',
                                        '</tpl>',
                                    '</td>',
                                    '<td>{[this.renderObject(values.example)]}</td>',
                                '</tr>',
                            '</tpl>',
                        '</table>',
 
                                         
                    
                        '<h2>Body:</h2>',
                        '<table>',
                            '<thead>',
                                '<th>Field Name</th>',
                                '<th>Description</th>',
                                '<th>Type</th>',
                                '<th>Required</th>',
                                '<th>Possible Values</th>',
                                '<th>Example</th>',
                            '</thead>',
                            '<tpl for="method.request.body_parts">',
                                '<tr>',
                                    '<td>{name}</td>',
                                    '<td>{description}</td>',
                                    '<td>{type}</td>',
                                    '<td>{required}</td>',
                                    '<td>',
                                        '<tpl for="possible_values">',
                                            '<div>{.}</div>',
                                        '</tpl>',
                                    '</td>',
                                    '<td>{[this.renderObject(values.example)]}</td>',
                                '</tr>',
                            '</tpl>',
                        '</table>',

                '</div>',
                
                { renderObject: renderObject }
            );
            
            content += request_content.apply( { "object": object, "method": method, "documentation_data": documentation_data } );
            
        // Response
            var response_content = new Ext.XTemplate(
                
                '<h1>Response</h1>',
                '<div class="content_block response">',
                    '<h2>Headers:</h2>',
                        '<table>',
                            '<thead>',
                                '<th>Header Name</th>',
                                '<th>Description</th>',
                                '<th>Type</th>',
                                '<th>Guaranteed</th>',
                                '<th>Possible Values</th>',
                                '<th>Example</th>',
                            '</thead>',
                            '<tpl for="method.response.headers">',
                                '<tr>',
                                    '<td>{name}</td>',
                                    '<td>{description}</td>',
                                    '<td>{type}</td>',
                                    '<td>{guaranteed}</td>',
                                    '<td>',
                                        '<tpl for="possible_values">',
                                            '<div>{.}</div>',
                                        '</tpl>',
                                    '</td>',
                                    '<td>{[this.renderObject(values.example)]}</td>',
                                '</tr>',
                            '</tpl>',
                        '</table>',

                        '<h2>Body:</h2>',
                        '<table class="parameters">',
                            '<thead>',
                                '<th>Field Name</th>',
                                '<th>Description</th>',
                                '<th>Type</th>',
                                '<th>Guaranteed</th>',
                                '<th>Possible Values</th>',
                                '<th>Example</th>',
                            '</thead>',
                            '<tpl for="method.response.body_parts">',
                                '<tr>',
                                    '<td>{name}</td>',
                                    '<td>{description}</td>',
                                    '<td>{type}</td>',
                                    '<td>{guaranteed}</td>',
                                    '<td>',
                                        '<tpl for="possible_values">',
                                            '<div>{.}</div>',
                                        '</tpl>',
                                    '</td>',
                                    '<td>{[this.renderObject(values.example)]}</td>',
                                '</tr>',
                            '</tpl>',
                        '</table>',
                        '<h2>Response Status:</h2>',
                        '<div class="text_block">',
                            '<ul>',
                                '<tpl for="method.response.status">',
                                    '<li>{.}</li>',
                                '</tpl>',
                            '</ul>',
                        '</div>',
                    
                '</div>',
                
                { renderObject: renderObject }
            );
            
            
            content += response_content.apply( { "object": object, "method": method, "documentation_data": documentation_data } );
            
        // Response
            var examples_content = new Ext.XTemplate(
                '<h1>Examples</h1>',
                '<tpl for="method.examples">',
                    '<div class="content_block">',
                        '<h2>{description}</h2>',
                        '<h3>Request:</h3>',
                        
                        '<div class="text_block">',
                        
                            '<ul>',
                                '<tpl for="request">',
                                    '<li>{.}</li>',
                                '</tpl>',
                            '</ul>',     
                        '</div>',                       
                        
                        '<h3>Request Body:</h3>',
                        '<div class="text_block">',
                            '{[this.renderObject(values.request_body)]}',
                        '</div>',
                        
                        '<h3>Response Headers:</h3>',
                        '<div class="text_block">',
                            '<ul>',
                                '<tpl for="response_headers">',
                                    '<li>{.}</li>',
                                '</tpl>',
                            '</ul>',
                        '</div>',

                        '<h3>Response Body:</h3>',
                        '<div class="text_block code">',
                            '{[this.renderObject(values.response_body)]}',
                        '</div>',
                        
                        
                    '</div>',
                '</tpl>',
                    
                
                
                { renderObject: renderObject }
            );
            
            content += examples_content.apply( { "object": object, "method": method, "documentation_data": documentation_data } );
            
            
            
            
        this.contentPanel.update( '<div id="content_body">' + content + '</div>');
            
        
        
/*        this.contentPanel.body.update(
            content
        );*/
            
        
    },
    
    
    /**
    * Renders an event's documentation onto the Content panel.
    * 
    * @param Object event              //Pointer to documentation_data > event
    * @param Object documentation_data
    */
    renderEventContent: function ( event, documentation_data ){

        var content = '';
        
        var renderObject = function( object ){
            
            if( typeof( object ) == 'undefined' ){
                return '';
            }
            
            if( typeof( object ) == 'string' ||  typeof( object ) == 'number'){
                return object;
            }
            
            return '<code><pre>' + JSON.stringify( object, null, ' ') + "</pre></code>";
        };
        
        
        // Heading
            var heading_content = new Ext.XTemplate(
            
                '<h1>Usage of Event: {event.name}</h1>',
                    
                    '<div class="content_block">',
                    '<h2>Description</h2>',
                        '<div class="text_block">',
                            '<p>{event.description}</p>',
                            
                            '<br /><b>Slug</b>: {event.slug}', 
                        '</div>',
                        
                            
                        
                    '</div>',
                    
                    { renderObject: renderObject }
            );

            content += heading_content.apply( { "event": event, "documentation_data": documentation_data } );
            
            
            
        // Requests
            var callback_content = new Ext.XTemplate(
                '<h1>Callback</h1>',
                '<div class="content_block request">',

                        '<h2>Body:</h2>',
                        '<table>',
                            '<thead>',
                                '<th>Field Name</th>',
                                '<th>Description</th>',
                                '<th>Type</th>',
                                '<th>Guaranteed</th>',
                                '<th>Possible Values</th>',
                                '<th>Example</th>',
                            '</thead>',
                            '<tpl for="event.callback.body_parts">',
                                '<tr>',
                                    '<td>{name}</td>',
                                    '<td>{description}</td>',
                                    '<td>{type}</td>',
                                    '<td>{guaranteed}</td>',
                                    '<td>',
                                        '<tpl for="possible_values">',
                                            '<div>{.}</div>',
                                        '</tpl>',
                                    '</td>',
                                    '<td>{[this.renderObject(values.example)]}</td>',
                                '</tr>',
                            '</tpl>',
                        '</table>',

                '</div>',
                
                { renderObject: renderObject }
            );
            
            content += callback_content.apply( { "event": event, "documentation_data": documentation_data } );
            
            
        // Response
            var examples_content = new Ext.XTemplate(
                '<h1>Examples</h1>',

                '<tpl for="event.callback.examples">',
                    '<div class="content_block">',
                        '<h2>{description}</h2>',
                        
                        '<div class="text_block">',
                            'Note: this request goes out from the system to your system using the URL you subscribed',
                        '</div>',
                        
                        '<h3>Request:</h3>',
                        
                        '<div class="text_block">',
                            '<ul>',
                                '<tpl for="request">',
                                    '<li>{.}</li>',
                                '</tpl>',
                            '</ul>',   
                        '</div>',                       
                        
                        '<h3>Request Body:</h3>',
                        '<div class="text_block">',
                            '{[this.renderObject(values.request_body)]}',
                        '</div>',
                        
                    '</div>',
                '</tpl>',

                    
                
                
                { renderObject: renderObject }
            );
            
            content += examples_content.apply( { "event": event, "documentation_data": documentation_data } );
            
            
            
        this.contentPanel.update( '<div id="content_body">' + content + '</div>');
            
        
        
/*        this.contentPanel.body.update(
            content
        );*/
            
        
    },
    
    
    
    
    
 /**
    * Renders the Home Page of the API
    * 
    * @param Object event              //Pointer to documentation_data > event
    * @param Object documentation_data
    */
    renderHomePage: function ( ){
        
        var documentation_data = this.getDocumentationDataObject();

        var content = '';
        
        var renderObject = function( object ){
            
            if( typeof( object ) == 'undefined' ){
                return '';
            }
            
            if( typeof( object ) == 'string' ||  typeof( object ) == 'number'){
                return object;
            }
            
            return '<code><pre>' + JSON.stringify( object, null, ' ') + "</pre></code>";
        };
        
        
        // Heading
            var heading_content = new Ext.XTemplate(
            
                '<h1>{documentation.title} v{documentation.version}</h1>',
                    
                    '<tpl for="documentation.description">',
                        '<div class="content_block">',

                            '<h2>{heading}</h2>',
                            
                            '<div class="text_block">',
                                '<ul>',
                                    '<tpl for="notes">',
                                        '<li>{.}</li>',
                                    '</tpl>',
                                '</ul>',   
                            '</div>', 
                            
                            
                        '</div>', 
                    '</tpl>',
                        

                    
                    { renderObject: renderObject }
            );

            
            content += heading_content.apply( { "documentation": documentation_data } );
            

            
        this.contentPanel.update( '<div id="content_body">' + content + '</div>');

    },
    
    
    
    
    
    
    
    
    
    /**
    * Processes a single Event from the documentation JSON and adds it to the "Events" portion of the menu.
    * 
    * @private
    * @return void
    */
    addDocumentationEvent: function( name, event, documentation_data ){

        var event_node = { 
            "text": event.name, 
            "documentation_data": documentation_data, 
            "event": event, 
            "icon": "/sfAltumoPlugin/images/silk/server_go.png",
            "leaf": true
        };
        
        event_node = this.menuPanel.getEventsNode().appendChild( event_node );
        
        
        
        
        // Add Methods
/*            Ext.each( object.methods, function( method, index, all_methods ){

                this.addDocumentationMethod(  method, object, documentation_data, object_node );
                //this.addDocumentationMethod(  method, object, documentation_data, menu_section_panel );
                
            }, this);*/
            
        // Add to menu panel
           // this.menuPanel.add( menu_section_panel );

    },    
    
    /**
     * Create the list of fields to be shown on the left
     * @private
     * @return {Documentation.MenuPanel} menuPanel
     */
    createMenuPanel: function(){
            
            this.menuPanel = Ext.create('Ext.tree.TreePanel', {
                tbar: Ext.create('widget.toolbar', {
                    items: [
                        Ext.create('Ext.Action', {
                            scope: this,
                            handler: function(){
                                this.renderHomePage();
                            },
                            text: 'Home',
                            icon: '/favicon.ico'
                        }),
                        Ext.create('Ext.Action', {
                            scope: this,
                            handler: function(){
                                this.showApiClientWindow();
                            },
                            text: 'API Client',
                            icon: '/sfAltumoPlugin/images/silk/application_xp_terminal.png'
                        })
                    ]
                }),
                region: 'west',
                width: 320,
                rootVisible: false,
                collapsible: false,
                store: new Ext.data.TreeStore({
                    rootVisible: false,
                    root: {
                        text: 'API',
                        id: 'root',
                        expanded: true,
                        icon: "/favicon.ico"
                    },
                    folderSort: true,
                    sorters: [{
                        property: 'text',
                        direction: 'ASC'
                    }]
                })
            });
            
            // Subscribe to item click events.
                this.menuPanel.on( 'itemclick', function( data_view, item, html_item, index, evt ) {
                    this.handleMenuItemClick( item );
                }, this);
                
            
            // Create node for objects    
                var objects_node = { 
                    "text": "Resources", 
                    "object": {}, 
                    "icon": "/sfAltumoPlugin/images/silk/bricks.png",
                    "expanded": true,
                    "leaf": false
                };
                

                objects_node = this.menuPanel.getRootNode().appendChild( objects_node );
                
                this.menuPanel.getObjectsNode = function(){
                    return objects_node;
                };                
            
            
            
            // Create node for events    
                var events_node = { 
                    "text": "Events", 
                    "documentation_data": {},
                    "event": {},
                    "icon": "/sfAltumoPlugin/images/silk/server_connect.png",
                    "expanded": true,
                    "leaf": false
                };
                

                events_node = this.menuPanel.getRootNode().appendChild( events_node );
                
                this.menuPanel.getEventsNode = function(){
                    return events_node;
                };

        return this.menuPanel;
    },
    
    /**
    * Shows the ApiClient Window
    * @private
    * @return void
    */
    showApiClientWindow: function (){
        
        this.getOrCreateApiClientWindow().show();
        
    },    
    
    /**
    * Get the ApiClient Window object. Creates the ApiClient Window if it doesn't exist
    * @private
    * @return ApiClient.ClientWindow
    */
    getOrCreateApiClientWindow: function (){
        
        if( !this.apiClientWindow ){
            this.apiClientWindow = Ext.create( 'ApiClient.ClientWindow', {
                default_authorization_header: this.default_authorization_header,
                closeAction: 'hide'
            });
        }
        
        return this.apiClientWindow;
    },

    handleMenuItemClick: function( item ){
        
        // Handle clicks on Event nodes
            if( item.get( 'event' ) ) {
                
                if( typeof( item.get( 'event' ).name ) != 'undefined'  ){
                
                    this.renderEventContent( item.get( 'event' ), item.get( 'documentation_data' ) );
                
                } else {
                    
                    this.renderHomePage();
                
                }
                
                
        // Handle clicks on Object or Method nodes nodes
            } else if( item.get('method' ) ) {
                
                if( typeof( item.get( 'method' ).route ) != 'undefined' ){
                    
                    this.renderMethodContent( item.get( 'method' ), item.get( 'object' ), item.get( 'documentation_data' ) );
                    
                } else {
                    // display first method as default.
                        item = item.getChildAt(0);
                        
                        if( item ){
                            
                            this.renderMethodContent( item.get( 'method' ), item.get( 'object' ), item.get( 'documentation_data' ) );
                            
                        } else {
                            
                            return;
                            
                        }
                }
                
                
                // Set default route on API client      
                    this.getOrCreateApiClientWindow().setRequestRouteValue( item.get( 'method' ).route );
           
                // Set default request method on API client      
                    this.getOrCreateApiClientWindow().setRequestMethodValue( item.get( 'method' ).http_method );
                   
                // Set default request parameters on API client      
                
                var request_parameters = {};
                
                Ext.each( item.get( 'method' ).request.parameters, function( object, index  ){
                    request_parameters[object.name] = '';
                });

                this.getOrCreateApiClientWindow().setRequestParametersValue( JSON.stringify( request_parameters ) ); 
                
                
                
            } else if( item.get( 'object' ) ) {
                
                this.renderHomePage();
                
            }
    },
    
    
    /**
     * Create the feed info container
     * @private
     * @return {Ext.panel.Panel} contentPanel
     */
    createContentPanel: function(){
        this.contentPanel = Ext.create('Ext.panel.Panel', {
            region: 'center',
            autoScroll: true
        });
        return this.contentPanel;
    },
    
    /**
    * Setter for DocumentationDataObject
    * 
    * @param Object data_object
    */
    setDocumentationDataObject: function ( data_object ){
        
        this._documentation_data_object = data_object;
        
    },
    
    /**
    * Getter for DocumentationDataObject
    */
    getDocumentationDataObject: function(){
        
        return this._documentation_data_object;
        
    }
});
