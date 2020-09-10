import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import Chat from './Chat';


export default class ChatList extends Component {
	constructor(props) {
	    super(props);
	    this.state = {
	    	isLoaded: false,
	    	stats: [],
	    	error: null
	    }
	}
	componentDidMount() {
		fetch("/api/chat/new?access_token=" + API_TOKEN, {
	    	method: 'GET',
	    	headers: {
	    		'X-Requested-With': 'XMLHttpRequest',
	    	}
	    })
      .then(res => res.json())
      .then(
        (result) => {
          this.setState({
            isLoaded: true,
            stats: result.data.stat,
          });
        },
        (error) => {
          this.setState({
            isLoaded: true,
            error: error
          });
        }
      )
	}
    render() {
    	const stats=this.state.stats;
    	let list=[];
    	stats.forEach(function (stat, index) {
    		list.push(<Chat key={index} other={stat.senderId} otherName={stat.senderName} unread={stat.count}></Chat>);
    	});
        return (
    		<div id="my-chat-list-container">
    			{list}
    		</div>
        );
    }
}

if (document.getElementById('my-chat-list')) {
    ReactDOM.render(<ChatList />, document.getElementById('my-chat-list'));
}
