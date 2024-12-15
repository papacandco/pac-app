import Loader from "../common/Loader";
import React, { useState } from "react";
import { ResponsiveTutorialCard } from "./Tutorial";

const TutorialIndex = () => {
  const [tutorials, setTutorials] = useState([]);
  const [url, setUrl] = useState('/ajax/tutorials?page=2');

  const onLoaderTutoriel = async (callback) => {
    const response = await fetch(url);
    const collection = await response.json();
    setTutorials([...tutorials, ...collection.data]);
    if (collection.next_page_url) {
      setUrl(collection.next_page_url);
    }
    if (typeof callback === 'function') {
      callback(typeof collection.next_page_url === 'string')
    }
  }

  return (
    <>
      {tutorials.map((tutorial) => (
        <ResponsiveTutorialCard
          key={tutorial.id}
          tutorial={tutorial}
          size={4}
        />
      ))}
      <Loader onLoaderElement={onLoaderTutoriel} />
    </>
  );
}

export default TutorialIndex;
