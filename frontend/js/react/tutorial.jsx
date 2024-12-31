import React from 'react';
import ReactDOM from 'react-dom';
import TutorialIndex from './components/tutorial';

if (document.getElementById('tutorial-root')) {
  ReactDOM.render(
    <TutorialIndex />,
    document.getElementById('tutorial-root')
  );
}
