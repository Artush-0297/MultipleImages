import React from 'react';
import ImageUploader from 'react-images-upload';

class App extends React.Component {
    constructor(props) {
        super(props);
        this.state = { pictures: [] };
        this.onDrop = this.onDrop.bind(this);
        this.insert = this.insert.bind(this);
    }

    onDrop(picture) {
        this.setState({
            pictures: this.state.pictures.concat(picture),
        });
    }

    insert(){
        let formData = new FormData();
        for(let key in this.state.pictures){
            formData.append(key,this.state.pictures[key]);
        }
        axios.post('/insert-images', formData).then(({data}) => {
            if (data.success){
                alert('Inserted');
            } else{
                alert(data.message);
            }
        })
    }

    render() {
        return (
            <div className='d-flex flex-column align-items-center'>
                <button onClick={this.insert} className='btn btn-success'>Insert</button>
                <ImageUploader
                    withPreview={true}
                    label={'Max file size: 2GB --- Accepted: cr2|dng|tiff|jpg|png|rar'}
                    withIcon={true}
                    buttonText='Choose files'
                    onChange={this.onDrop}
                    imgExtension={['cr2', 'dng', 'tiff', 'jpg', 'png', 'rar']}
                    maxFileSize={2048000000}
                />
            </div>
        );
    }
}


export default App;
