import React from 'react';

const Message = ({ author, message }) => {
  return (
    <div className="media">
      <div className="media-body">
        <div className="text-muted" style={{ fontSize: "12px" }}>
          { author.name } <span className="label label-primary">{message.at}</span>
        </div>
        <div  style={{ fontSize: "14px", marginBottom: "10px" }}>
          <strong style={{ fontWeight: "normal", color: "#fff" }}>
            {message.content}
          </strong>
        </div>
      </div>
    </div>
  );
}

export default Message;
