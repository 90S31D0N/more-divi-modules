import React, { Component } from 'react';
import './style.css';

class ContactChip extends Component {
  static slug = 'mdm-contact-chip-module';

  constructor(props) {
    super(props);
    this.state = {
      siteUrl: ''
    };
  }

  componentDidMount() {
    this.getSiteUrl();
  }

  getSiteUrl = async () => {
    try {
      const response = await fetch("/wp-json");
      const data = await response.json();
      this.setState({ siteUrl: data.home });
    } catch (error) {
      console.error("Error fetching site URL:", error);
    }
  };

  render() {
    const { post_select } = this.props;
    const { siteUrl } = this.state;

    return (
      <div>
        <h2>Post ID: {post_select}</h2>
        <p>Site URL: {siteUrl || "Loading..."}</p>
        <p>Slug: {ContactChip.slug}</p> {/* Displaying the slug */}
      </div>
    );
  }
}

export default ContactChip;
