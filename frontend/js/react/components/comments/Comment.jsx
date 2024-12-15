import React from "react";

const CommentFormContainer = ({ commentId }) => (
  <div id={`coment-form-conatiner-${commentId}`}></div>
);

const Avatar = ({ user }) => {
  return (
    <div className="media-left">
      <div className="media-object">
        <img className="img-circle img-responsive" src={user.avatar} style={{width: "40px", height: "40px"}} />
      </div>
    </div>
  );
}

const CommentBody = ({ comment }) => {
  return (
    <div className="media-body" style={{fontSize: "15px"}}>
      <span className="text-muted pull-right" style={{fontSize: "13px"}}>
        {comment.created_at}
      </span>
      <strong>{comment.user.name}</strong>
      <p style={{marginTop: "10px"}}>{comment.content}</p>
      <div className="pull-right">
        <a href="#" className="reply-comment" data-comment={comment.id} data-commentable={comment.commentable_id}>
          { "Répondre" }
        </a>
      </div>
    </div>
  )
}

const Comment = () => {
  const { comment } = this.props;

  return (
    <React.Fragment>
      <div className="media bg-white border-blue" style={{padding: "10px"}} id={`scroll-element-${comment.id}`}>
        <Avatar user={comment.user} />
        <CommentBody comment={comment}/>
        <CommentFormContainer commentId={comment.id} />
      </div>
      {comment.isParent && comment.comments.length > 0 && (
        <div style={{marginLeft: "50px", marginTop: "2px"}}>
          {comment.comments.map((child, index) =>
            <Comment comment={child} key={index + comment.id}/>
          )}
        </div>
      )}
    </React.Fragment>
  );
}

export default Comment;
