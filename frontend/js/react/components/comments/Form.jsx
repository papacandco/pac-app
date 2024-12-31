import React from "react";

const UserInfo = () => {
  return (
    <React.Fragment>
      <div className="col-sm-6">
        <div className="form-group">
          <input type="text" name="name" className="form-control" placeholder="Nom complet"/>
        </div>
      </div>
      <div className="col-sm-6">
        <div className="form-group">
          <input type="email" name="email" className="form-control" placeholder="Votre Email"/>
        </div>
      </div>
    </React.Fragment>
  );
}

const CommentContent = () => {
  return (
    <React.Fragment>
      <div className="col-sm-12">
        <div className="form-group">
          <textarea name="content" className="form-control" style={{resize: "none"}} placeholder="Votre commentaire ici..."/>
        </div>
      </div>
    </React.Fragment>
  );
}

const CommentArea = () => {
  const { route, children } = this.props;

  return (
    <div id="comment-form">
      <form action={route} method="POST">
        {children}
      </form>
    </div>
  );
}

const CommentButton = () => {
  return (
    <div className="form-group text-left">
      <button className="btn btn-primary">Envoyer</button>
    </div>
  )
}

const CommentForm = () => {
  return (
    <CommentArea>
      <div className="row">
        <UserInfo />
        <CommentContent />
      </div>
      <CommentButton />
    </CommentArea>
  );
}

export default CommentForm;
