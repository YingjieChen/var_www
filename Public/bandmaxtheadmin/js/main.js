$(function()
{
    require.config({
        // baseUrl: "js/lib",
        paths: {
            "react": "http://cdn.bootcss.com/react/15.3.2/react.min",
            "ReactDOM": "http://cdn.bootcss.com/react/15.3.2/react-dom.min",
        }
    });
    require(["react","ReactDOM"], function (React,ReactDOM){
        // some code here
        console.log(React);
    });
    // math.js
    define(function (){
        var add = function (x,y){
            return x+y;
        };
        return {
            add: add
        };
    });
    define([
            'text!review.txt',
            'image!cat.jpg'
        ],

        function(review,cat){
        }
    );
});