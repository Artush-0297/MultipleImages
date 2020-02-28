import React from 'react';
import {BrowserRouter, Switch, Route} from "react-router-dom"
import routes from "../routes/routes"
import Header from "./Header/Header";

const App = () => {
    return (
        <BrowserRouter>
            <main>
                <Header/>
                <Switch>
                    {routes.map((route, i) => (
                        <Route
                            exact={route.exact}
                            key={'route-' + route.path + '-' + i}
                            path={route.path}
                            render={() => <route.component/>}
                        />
                    ))}
                </Switch>
            </main>
        </BrowserRouter>
    );
};

export default App;
