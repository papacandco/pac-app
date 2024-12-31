import React from 'react';

export const SmallCard = ({ tutorial }) => {
  return (
    <div className="thumbnail bg-white visible-xs rounded" style={{cursor: "default", margin: "10px", overflow: "hidden"}}>
      <a className="bg-blue" title={tutorial.title} href={tutorial.route}  style={{display: "block", minHeight: "150px"}}>
        <img src={tutorial.cover} className="img-responsive" alt={tutorial.title} />
      </a>
      <div className="caption">
        <div className="pull-right">
          <a href={tutorial.technologie_route}>
            <img src={tutorial.technologie.cover} className="img-circle img-responsive" style={{width: "22px"}} />
          </a>
        </div>
        <div className="text-left">
          <strong>
            <a title={tutorial.title} href={tutorial.route}>
              {tutorial.title}
            </a>
          </strong>
        </div>
        <p className="text-muted" style={{fontSize: "11px"}}>
          {"Durée: "}<b className="text-info">{tutorial.duration}</b>
          {" Par "}<span className="text-muted">{tutorial.author.name}</span>
          {tutorial.premium === 1 && <span> &nbsp; <i class="fa fa-star text-warning" title="Premium"></i> &nbsp; Premium</span>}
        </p>
      </div>
    </div>
  );
}

export const MediumCard = ({ tutorial }) => {
  return (
    <>
      <div className="thumbnail bg-white hidden-xs rounded" style={{overflow: "hidden", cursor: "default", maxHeight: "400px", minHeight: "450px"}}>
        <a className="bg-blue" title={tutorial.title} href={tutorial.route}  style={{display: "block", minHeight: "150px"}}>
          <img src={tutorial.cover} className="img-responsive" alt={tutorial.title} />
        </a>
        <div className="caption">
          <div className="text-left">
            <strong>
              <a title={tutorial.title} href={tutorial.route}>
                {tutorial.title_truncated}
              </a>
            </strong>
          </div>
          <p className="text-muted" style={{fontSize: "15px"}}>
            Durée: <b className="text-info">{tutorial.duration}</b>
            {tutorial.premium === 1 && <span style={{fontSize: "13px"}}> &nbsp; <i class="fa fa-star text-warning" title="Premium"></i> &nbsp; Premium</span>}
          </p>
          <p style={{fontSize: "1.4rem", lineHeight: "1.7"}} title={tutorial.description}>
            {tutorial.description_truncated}
          </p>
        </div>
      </div>
      <a className="hidden-xs" href={tutorial.technologie_route}>
        <span className="course-metadata clearfix">
          <span className="course-metadata__technologie">
            <img src={tutorial.technologie.cover} className="img-responsive pull-left" style={{width: "10px", position: "relative", left: -2, top: 1, marginRight: 3}}/>
              {tutorial.technologie.title}
            </span>
        </span>
      </a>
    </>
  )
}

export const ResponsiveTutorialCard = ({ tutorial, size = 4 }) => {
  return (
    <>
      <div className={"col-sm-" + size + " col-xs-12 tutorial-item"} style={{paddingLeft: "5px", paddingRight: "5px", paddingBottom: "0px", marginBottom: "10px" }}>
        <SmallCard tutorial={tutorial}/>
        <MediumCard tutorial={tutorial}/>
      </div>
    </>
  );
};

