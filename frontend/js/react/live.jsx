import React from 'react';
import ReactDOM from 'react-dom';
import LiveContainer from './components/challenge';

if (document.getElementById('challenge-container')) {
  ReactDOM.render(
    <LiveContainer />,
    document.getElementById('challenge-containe')
  );
}
