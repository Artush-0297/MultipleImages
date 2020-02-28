import React from 'react';
import ImageUploader from 'react-images-upload';

class Insert extends React.Component {
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
                    label='Max file size: 20mb, accepted: jpg|jpeg|gif|png'
                    withIcon={true}
                    buttonText='Choose images'
                    onChange={this.onDrop}
                    imgExtension={['.jpg', '.jpeg', '.gif', '.png']}
                    maxFileSize={20971520}
                />
            </div>
        );
    }
}

export default Insert;
