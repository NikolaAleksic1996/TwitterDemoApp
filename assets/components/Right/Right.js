import React from 'react';

import Message from "./Message";
import Input from "./Input";

class Right extends React.Component {

    render() {
        return(
            <div className="col-7 px-0">
                <div className="px-4 py-5 chat-box bg-white">
                    <Message/>
                </div>

                <Input />
            </div>
        );
    }
}

export default Right;