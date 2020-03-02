import React, {Component} from 'react';
import Plupload from 'react-plupload';
import $ from 'jquery'

class App extends Component {
    render() {
        return (
            <Plupload
                id="plupload"
                multipart
                chunk_size="1mb"
                url={'/upload?_token=' + $('meta[name="csrf-token"]').attr('content')}
            />
        );
    }
}

export default App;
