// External Dependencies
import React, { Component } from 'react';

// Internal Dependencies
import './styles.css';


class ContactChip extends Component {

    static slug = 'mdm-contact-chip-module';

    constructor(props) {
        super(props);
        this.state = {
            siteUrl: '',
            postTitle: '',
            postThumbId: 0,
            postThumb: '',
        };
    }

    componentDidMount() {
        this.getSiteUrl();
        this.getPost();
    }

    componentDidUpdate(prevProps) {
        if (prevProps.post_select !== this.props.post_select) {
            this.getPost();
        }
    }

    getSiteUrl = async () => {
        try {
            const response = await fetch('/wp-json');
            const data = await response.json();
            this.setState({ siteUrl: data.home });
        } catch (error) {
            console.error("Error fetching site URL: ", error);
        }
    }

    getPost = async () => {
        console.log("Post Type: ", this.props.post_type);
        fetch(this.state.siteUrl + '/wp-json/wp/v2/' + this.props.post_type + '/' + this.props.post_select)
            .then((res) => res.json())
            .then((data) => {
                this.setState({
                    postTitle: data.title.rendered,
                    postThumbId: data.featured_media,
                })
                // console.log(this.state.postThumbId)
                fetch(this.state.siteUrl + '/wp-json/wp/v2/media/' + this.state.postThumbId)
                    .then((res) => res.json())
                    .then((data) => {
                        this.setState({
                            postThumb: data.guid.rendered,
                        })
                        // console.log(data.guid.rendered)
                    })
                    .catch((error) => console.error("Error fetching Thumb: ", error))
            })
            .catch((error) => console.error("Error fetching Post:", error))
    }

    render() {
        // this.getPost();

        // const postId = this.props.post_select;
        const postTitle = this.state.postTitle;
        const postThumb = this.state.postThumb;
        // const postType = this.props.post_type;
        // console.log(postTitle + ' -- ' + postThumb)
        // console.log(postID)
        return (
            <div className='mdm-contact-chip-module'>
                <img src={postThumb} alt={postTitle} />
                <p>{postTitle}</p>
            </div>
        );
    }
}

export default ContactChip;
