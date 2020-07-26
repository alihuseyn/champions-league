import $ from 'jquery';

const post = url => {
  return new Promise((resolve, reject) => {
    $.ajax({
      url,
      method: 'POST',
      headers: {
        'X-CSRF-Token': $('meta[name="token"]').attr('content')
      },
      success: response => resolve(response),
      error: xhr => reject(JSON.parse(xhr.responseText))
    });
  });
};

export default { post };
