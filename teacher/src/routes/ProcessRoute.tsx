import { Route } from "react-router"

export default function ProcessRoute(entry: any) { return <Route key={entry.path} {...entry} exact /> }
