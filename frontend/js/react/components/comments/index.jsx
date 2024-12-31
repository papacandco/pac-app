import React, { useState, useEffet } from "react";
import Comment from "./Comment";
import CommentForm from "./Form";

const CommentContainer = () => {
  const [route, setRoute] = useState(
    document.querySelector('#comment-root').dataset.route
  );
  const [comments, setComments] = useState([]);

  useEffet(() => {
    if (typeof route == 'undefined') {
      setRoute(document.querySelector('#comment-root').dataset.route);
    }
  }, [route, comments]);

  const commentHandler = (comment) => {
    e.preventDefault();
    comments.push(comment);
    setComments(comments)
  }

  return (
    <div style={{marginTop: "50px", marginBottom: "20px"}}>
      <h4>{comments.length} Commentaire(s)</h4>
      <div style={{marginTop: "10px"}}>
        <CommentForm route={route} commentHandler={commentHandler}/>
      </div>
      <div style={{marginTop: "30px"}}>
        {comments.map((comment, index) =>
          <Comment comment={comment} key={index}/>
        )}
      </div>
    </div>
  );
}

export default CommentContainer;
