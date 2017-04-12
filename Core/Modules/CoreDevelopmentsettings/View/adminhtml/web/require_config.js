(function () {
   
    var config = {       
        paths: {
            jquery: ["https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min","jquery.min"]
            //jquery: "https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min"
                        
        },deps: ["jquery"]
    };
    require.config(config);
})();
(function () {
   
    var config = {       
        shim: {
            "functions":["jquery"]           
        },deps: ["functions"]
    };
    require.config(config);
})();
(function () {    /**
     * Copyright © 2016 Magento. All rights reserved.
     */
    var config = {
        map: {
            '*': {
                sidemenu: 'Modules/side_menu', 
            }
        },
        shim:{
            sidemenu: ["jquery"]
        },
        "deps": ["sidemenu"]
    };
    require.config(config);
})();
(function () {    /**
     * Copyright © 2016 Magento. All rights reserved.
     */
    var config = {
        map: {
            '*': {
                functions: 'Modules/functions', 
            }
        },
        shim:{
            functions: ["jquery"]
        },
        "deps": ["functions"]
    };
    require.config(config);
})();