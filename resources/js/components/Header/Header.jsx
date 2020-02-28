import React from 'react';
import {NavLink} from "react-router-dom"

const Header = () => {
    return (
        <header>
            <ul>
                <li>
                    <NavLink exact to="/">Images</NavLink>
                </li>
                <li>
                    <NavLink exact to="/insert">Insert</NavLink>
                </li>
            </ul>
        </header>
    );
};

export default Header;
