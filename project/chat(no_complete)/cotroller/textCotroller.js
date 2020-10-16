function doData(request) {
  let postParams = request.params.post;
  return JSON.stringify(postParams);
}

module.exports = {
  doData,
};
