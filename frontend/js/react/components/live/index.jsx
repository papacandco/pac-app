import React from "react";
import Message from "./Message";

const LiveContainer = () => {
  return (
    <div className="row" id="curriculum-video-list" style={{overflowY: "scroll", padding: "5px", "paddingBottom": "10px", paddingTop: "20px" }}>
        <div className="col-sm-12" id="curriculum-video">
          <Message />
        </div>
    </div>
  );
}

export default LiveContainer;
