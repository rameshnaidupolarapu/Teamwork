(function () {    /**
     * bootstrap theme file
     */
    var config = {
        map: {
            '*': {
                bootstrap: 'bootstrap', 
            }
        },
        shim:{
            bootstrap:{
                deps:["jquery"]
            }
        },
        "deps": ["bootstrap"]
    };
    require.config(config);
})();