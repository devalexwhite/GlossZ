"use strict";!function(){$(document).ready(function(){var t=!1;$(".glossary-enable-edit").click(function(){t=!t,t?($(".glossary-enable-edit").removeClass("fa-pencil").addClass("fa-floppy-o"),$("#glossary-title").attr("contenteditable","true"),$("#glossary-title").focus()):($("#glossary-title").attr("contenteditable","false"),$(".glossary-enable-edit").removeClass("fa-floppy-o").addClass("fa-pencil"),$.ajax({type:"POST",url:window.location.pathname+"/update",data:{title:$("#glossary-title").text()}}).done(function(t){console.log(t),t.errors&&t.errors.length>0&&alert("failed to save")}))}),$(".glossary-delete").click(function(){1==confirm("Are you sure you wish to delete this glossary?")&&(window.location=window.location.pathname+"/delete")}),$(document).on("click",".glossary-translations-add-button",function(){var t=$("#glossary-translations-add-form").attr("term-id");$.ajax({type:"POST",url:"/term/"+t+"/translation",data:$("#glossary-translations-add-form").serialize()}).done(function(a){a.errors.length>0?alert("Encountered an error, please try again."):$.ajax({type:"GET",url:"/term/"+t+"/translation"}).done(function(a){$(".glossary-terms-term-card[term-id='"+t+"']").html(a)})})})})}();