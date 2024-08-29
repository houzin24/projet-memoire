$('.datepicker').datepicker();
$.fn.datepicker.defaults.format = "dd/mm/yyyy";
$.fn.datepicker.defaults.language = 'fr';
$.fn.datepicker.defaults.autoclose = true;
$.fn.datepicker.defaults.orientation = 'bottom';

!function(a){a.fn.datepicker.dates.fr={
    days:["dimanche","lundi","mardi","mercredi","jeudi","vendredi","samedi"],
    daysShort:["dim.","lun.","mar.","mer.","jeu.","ven.","sam."],
    daysMin:["d","l","ma","me","j","v","s"],
    months:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],
    monthsShort:["Janv.","Févr.","Mars","Avril","Mai","Juin","Juil.","Août","Sept.","Oct.","Nov.","Déc."],
    today:"Aujourd'hui",monthsTitle:"Mois",clear:"Effacer",weekStart:1,format:"dd/mm/yyyy"}}
(jQuery);

(function($){
    $(window).on("load",function(){
        $(".content").mCustomScrollbar();
    });
})(jQuery);