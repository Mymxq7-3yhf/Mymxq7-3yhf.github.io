function getNoticeComponent(data) {
  let node = document.createElement("marquee");

  node.setAttribute("onMouseout", "this.start()");
  node.setAttribute("class", "chat-notice");
  node.setAttribute("onMouseover", "this.stop()");

  let textNode = getTextNode(data);

  node.appendChild(textNode);

  return node;
}
function getTipsComponent(data) {
  let nodes = document.createElement("div");

  nodes.setAttribute("class", "chat-tips");

  let textNode = getTextNode(data);

  nodes.appendChild(textNode);

  return nodes;
}

function getTextNode(data) {
  let textNode = document.createTextNode(data);

  return textNode;
}
