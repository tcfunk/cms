!function(a){function b(b,e){"undefined"!=typeof e.html&&($html=a(e.html),d(b),b.replaceWith($html),c($html))}function c(c){var d=c.data("type"),e={modalClass:"cp-image-modal",uploadAction:"rebrand/upload-site-image",deleteMessage:Craft.t("Are you sure you want to delete the uploaded image?"),deleteAction:"rebrand/deleteSiteImage",cropAction:"rebrand/crop-site-image",constraint:300,areaToolOptions:{aspectRatio:"",initialRectangle:{mode:"auto"}}};e.onImageSave=a.proxy(function(c){b(a(this),c)},c),e.onImageDelete=a.proxy(function(c){b(a(this),c)},c),e.uploadButton=c.find(".upload"),e.deleteButton=c.find(".delete"),e.postParameters={type:d},c.data("imageUpload",new Craft.ImageUpload(e))}function d(a){"object"==typeof a.data("imageUpload")&&(a.data("imageUpload").destroy(),a.data("imageUpload",null))}for(var e=a(".cp-image"),f=0;f<e.length;f++)c(e.eq(f))}(jQuery);
//# sourceMappingURL=rebrand.js.map