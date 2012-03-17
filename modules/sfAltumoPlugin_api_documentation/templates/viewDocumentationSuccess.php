<?php

    use_javascript( 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' );
    use_javascript( '/sfAltumoPlugin/js/lib/vendor/json-org/json.js' );
    //use_javascript( '/js/api/widgets/alApiDocumentationBrowserWidget.js' );
    use_javascript( '/sfAltumoPlugin/js/lib/vendor/sencha/ext-4.0.2a/bootstrap.js' );
    
    use_javascript( '/sfAltumoPlugin/js/api/documentation/ApiClient.js' );
    use_javascript( '/sfAltumoPlugin/js/api/documentation/Documentation.js' );

    //use_stylesheet( '/css/blueprint/screen.css' );
    use_stylesheet( '/sfAltumoPlugin/js/lib/vendor/sencha/ext-4.0.2a/resources/css/ext-all.css' );
    use_stylesheet( '/sfAltumoPlugin/css/api/documentation.css' );
    
?>
<script type="text/javascript"> 

    Ext.Loader.setConfig({enabled: true});
    
    Ext.require([
        'Ext.grid.*',
        'Ext.tree.*',
        'Ext.data.*',
        'Ext.util.*',
        'Ext.Action',
        'Ext.tab.*',
        'Ext.button.*',
        'Ext.form.*',
        'Ext.layout.container.Card',
        'Ext.layout.container.Border'
    ]);
    
    Ext.onReady(function(){
        
        var app = new Documentation.App({
            <?php if( !in_array( sfConfig::get('sf_environment'), array( 'production' ) ) ): ?>
                default_authorization_header: "Basic czEPgiRdcAPIedJGOpMFbNwyuDKkzCqP",
            <?php endif; ?>
            documentation_data_route: "<?php echo $documentation_json_route; ?>",
            border: 0,
            frame:false
        });
    });
</script> 
<div id="api_documentation_body">
</div>