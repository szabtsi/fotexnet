import React, { useEffect, useState } from "react";
import { Link, useParams } from "react-router";
import axios from "axios";
import dayjs from "dayjs";
import { Spin } from "antd";

const Movie = () => {
    const { id } = useParams();
    const [movie, setMovie] = useState({});
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        fetchMovie();
    }, []);

    console.log(movie);

    const fetchMovie = async () => {
        setLoading(true);

        try {
            const response = await axios.get(
                "http://localhost:80/api/v1/movies/" + id
            );

            if (response.status === 200) {
                const { data } = response.data;
                setMovie(data);
            }
            setLoading(false);
        } catch (error) {
            console.log(error);
            setLoading(false);
        }
    };

    return (
        <Spin spinning={loading}>
            <small>
                <Link to="/">Back to movies</Link>
            </small>
            <h1>{movie?.title}</h1>
            <p>{movie?.description}</p>
            <p>Language: {movie?.language}</p>
            <p>Age limit: {movie?.age_limit}</p>
            <img
                src={movie?.cover}
                alt={movie?.title}
                style={{ width: "100%" }}
            />
            <h3>Screenings:</h3>
            <ul>
                {movie?.screenings?.map((screening) => (
                    <li key={screening.id} style={{ marginBottom: 10 }}>
                        <ul style={{ listStyleType: "none" }}>
                            <li>
                                Starts At:{" "}
                                {dayjs(screening.starts_at).format(
                                    "YYYY.MM.DD. HH:mm"
                                )}
                            </li>
                            <li>
                                Available Seats: {screening.available_seats}
                            </li>
                        </ul>
                    </li>
                ))}
            </ul>
        </Spin>
    );
};

export default Movie;
