$(document).ready(function() {
  CKEDITOR.replace("email_content");
  $("form[name='frmemailtemplate']").validate({
    rules: {
      email_subject: "required",
      email_slug: "required",
      email_content: "required",
    },
    messages: {
      email_subject: "Email subject is required.",
      email_slug: {
        required: "Email slug is required",
      },
      email_content: {
        required: "Email content is required",
      },
    },
  });
});

function check() {
  return confirm("Are you sure you want to delete");
}
