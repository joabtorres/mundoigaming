/**
 * @author Joab Torres Alencar
 * @description classes para tratamento de preenchimento de campos
 */
$(document).ready(function () {
   //menu
   $("#sidebar").mCustomScrollbar({ theme: "minimal" });
   $("#dismiss, .overlay").on("click", function () {
      $("#sidebar").removeClass("active");
      $(".overlay").removeClass("active");
   });
   $("#sidebarCollapse").on("click", function () {
      $("#sidebar").addClass("active");
      $(".overlay").addClass("active");
      $(".collapse.in").toggleClass("in");
      $("a[aria-expanded=true]").attr("aria-expanded", "false");
   });
   $(".custom-file-input").on("change", function () {
      var fileName = $(this).val().split("\\").pop();
      $(this)
         .siblings(".custom-file-label")
         .addClass("selected")
         .html(fileName);
   });

   //forms
   $(".custom-select").select2({ width: "100%" });
   $(".input-data").mask("99/99/9999");

   /**
    * @author Joab Torres <joabtorres1508@gmail.com>
    * @description Este codigo abaixo é responsável para fazer o carregamento do datePicker
    */

   $(".date_serach").datepicker({
      changeYear: true,
      changeMonth: true,
      dateFormat: "dd/mm/yy",
   });
   $(".modal").on("show.bs.modal", function (e) {
      var datePicker = document.getElementById("ui-datepicker-div");
      if (datePicker) {
         e.delegateTarget.appendChild(datePicker);
      }
   });
   $(".modal").on("hide.bs.modal", function (e) {
      var datePicker = document.getElementById("ui-datepicker-div");
      if (datePicker) {
         $("body").append(datePicker);
      }
   });
});
/**
 * @author Joab Torres <joabtorres1508@gmail.com>
 * @description Valida o formulário que tiver a classe needs-validation
 */
(function () {
   "use strict";
   window.addEventListener(
      "load",
      function () {
         var forms = document.getElementsByClassName("needs-validation");
         var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener(
               "submit",
               function (event) {
                  if (form.checkValidity() === false) {
                     event.preventDefault();
                     event.stopPropagation();
                  }
                  form.classList.add("was-validated");
               },
               false
            );
         });
      },
      false
   );
})();

/**
 * @author Joab Torres <joabtorres1508@gmail.com>
 * @description Este codigo abaixo é responsável para verifica se o elemento está vazio
 * @returns boolean
 */
function null_or_empty(str) {
   var v = document.getElementById(str).value;
   return v == null || v == "";
}

$(function () {
   //ajax form
   $("form:not('.ajax_off')").submit(function (e) {
      e.preventDefault();
      var form = $(this);
      var load = $(".ajax_load");
      var flashClass = "ajax_response";
      var flash = $("." + flashClass);

      form.ajaxSubmit({
         url: form.attr("action"),
         type: "POST",
         dataType: "json",
         beforeSend: function () {
            load.fadeIn(200).css("display", "flex");
         },
         success: function (response) {
            //redirect
            if (response.redirect) {
               window.location.href = response.redirect;
            }

            //message
            if (response.message) {
               if (flash.length) {
                  flash.html(response.message).fadeIn(100).effect("bounce", 300);
               } else {
                  form.prepend("<div class='" + flashClass + "'>" + response.message + "</div>")
                     .find("." + flashClass).effect("bounce", 300);
               }
            } else {
               flash.fadeOut(100);
            }
         },
         complete: function () {
            load.fadeOut(200);

            if (form.data("reset") === true) {
               form.trigger("reset");
            }
         }
      });

   })
});