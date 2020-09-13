# Listing commands:

```
docker ps
```

# Listing all commands that had been created:

```
docker ps --all
```

# docker run = docker create <image name> + docker start <container id>

# delete stopped containers

```
docker system prune
```

# retrieving log output

```
docker logs <container id>
```

# `termination` means allowing a period of time to shut down and `kill` means right now or die.

# docker stop a container:

```
docker stop <container id>
```

# docker kill a container:

```
docker kill <container id>
```

# Execute an additional command in a container:

```
docker exec -it <container id> <command>
```

(-it = -i + -t) --> -t is just to make things beautiful (-i is still ok)

# Getting a command prompt in a container

```
docker exec -it shell
```

# Docker run with port mapping

```
docker run -p 8080 : 8080 <image id>

// First port is from the localhost of the parent machine

// Second port is the port inside the container
```

#Docker Volumes

```
sudo docker run -p 3000:3000 -v /app/node_modules -v $(pwd):/app <image id>
```

--> pwd is present working directory

#Find IP of Container
docker exec -it (container id) hostname -i