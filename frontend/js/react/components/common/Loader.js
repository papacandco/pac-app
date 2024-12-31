import React, { useState } from "react";

const Loader = ({ onLoaderElement }) => {
  const [showSpinner, setShowSpinner] = useState('hidden')
  const [showLoadingButton, setShowLoadingButton] = useState(true)

  const onShowSpinner = (e) => {
    setShowSpinner('');
    onLoaderElement(function (next) {
      setShowSpinner('hidden');
      setShowLoadingButton(next);
    });
  }

  return (
    (showLoadingButton &&
      <>
        <div style={{display: 'flex', justifyContent: 'center'}}>
          <div className={showSpinner}>
            <div className="spinner">
              <div className="rect1" style={{marginLeft: 5}}></div>
              <div className="rect2" style={{marginLeft: 5}}></div>
              <div className="rect3" style={{marginLeft: 5}}></div>
              <div className="rect4" style={{marginLeft: 5}}></div>
              <div className="rect5" style={{marginLeft: 5}}></div>
            </div>
          </div>
        </div>
        <div className={"row " + (showSpinner != 'hidden' ? 'hidden' : '')} style={{marginBottom: 30}}>
          <div className="col-sm-offset-4 col-sm-4 text-center" style={{marginTop: "10px"}}>
            <button className="btn btn-success btn-block" onClick={onShowSpinner}><i className="fa fa-arrow-bottom"></i> Affichez plus de tutoriel</button>
          </div>
        </div>
      </>
    )
  )
}

export default Loader;
