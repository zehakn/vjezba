var Constants = {
  get_api_base_url: function () {
    if (location.hostname === 'localhost') {
      return "http://localhost/vjezbafinal/backend/rest";
    } else {
      return ""; 
    }
  }
};
