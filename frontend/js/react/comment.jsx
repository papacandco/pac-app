import React from "react";
import ReactDOM from "react-dom";
import CommentContainer from "./components/comments";

if (document.getElementById('comment-root')) {
  ReactDOM.render(
    <CommentContainer />,
    document.getElementById('comment-root')
  );
}
